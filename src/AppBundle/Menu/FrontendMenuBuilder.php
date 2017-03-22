<?php

namespace AppBundle\Menu;

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
     * Methods.
     */

    /**
     * @param FactoryInterface      $factory
     * @param AuthorizationChecker  $ac
     * @param TokenStorageInterface $ts
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac, TokenStorageInterface $ts)
    {
        $this->factory = $factory;
        $this->ac = $ac;
        $this->ts = $ts;
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
}
