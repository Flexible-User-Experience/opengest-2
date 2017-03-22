<?php

namespace AppBundle\Menu;

use AppBundle\Entity\VehicleCategory;
use AppBundle\Repository\VehicleCategoryRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class FrontendMenuBuilder.
 *
 * @category Menu
 *
 * @author   David Romaní <david@flux.cat>
 */
class FrontendMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var AuthorizationChecker
     */
    private $ac;

    /**
     * @var TokenStorageInterface
     */
    private $ts;

    /**
     * @var VehicleCategoryRepository
     */
    private $vcr;

    /**
     * Methods.
     */

    /**
     * @param FactoryInterface          $factory
     * @param AuthorizationChecker      $ac
     * @param TokenStorageInterface     $ts
     * @param VehicleCategoryRepository $vcr
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac, TokenStorageInterface $ts, VehicleCategoryRepository $vcr)
    {
        $this->factory = $factory;
        $this->ac = $ac;
        $this->ts = $ts;
        $this->vcr = $vcr;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createTopMenu(RequestStack $requestStack)
    {
        //        $route = $requestStack->getCurrentRequest()->get('_route');
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        if ($this->ts->getToken() && $this->ac->isGranted('ROLE_CMS')) {
            $menu->addChild(
                'admin',
                array(
                    'label' => '[ CMS ]',
                    'route' => 'sonata_admin_dashboard',
                )
            );
        }
        $menu->addChild(
            'front_services',
            array(
                'label' => 'Servicios',
                'route' => 'front_services',
//                'current' => $route == 'front_blog' || $route == 'front_blog_detail' || $route == 'front_blog_tag_detail',
            )
        );
        $menu->addChild(
            'front_vehicles',
            array(
                'label' => 'Vehículos',
                'route' => 'front_vehicles',
//                'current' => $route == 'front_coworkers_list' || $route == 'front_coworker_detail',
            )
        );
        $menu->addChild(
            'front_works',
            array(
                'label' => 'Trabajos',
                'route' => 'front_works',
//                'current' => $route == 'front_events_list' || $route == 'front_event_detail' || $route == 'front_category_event',
            )
        );
        $menu->addChild(
            'front_company',
            array(
                'label' => 'Empresa',
                'route' => 'front_company',
            )
        );

        return $menu;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createVehicleCategoryMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('rootCategory');
        $categories = $this->vcr->findEnabledSortedByName();

        /** @var VehicleCategory $category */
        foreach ($categories as $category) {
            $menu->addChild(
                $category->getSlug(),
                array(
                    'label' => $category->getName(),
                    'route' => 'front_vehicles_category',
                    'routeParameters' => array(
                        'slug' => $category->getSlug(),
                    ),
                )
            );
        }

        return $menu;
    }
}
