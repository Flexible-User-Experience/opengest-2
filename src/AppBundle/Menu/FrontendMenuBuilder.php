<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Service;
use AppBundle\Entity\VehicleCategory;
use AppBundle\Entity\Work;
use AppBundle\Repository\ServiceRepository;
use AppBundle\Repository\VehicleCategoryRepository;
use AppBundle\Repository\WorkRepository;
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
     * @var ServiceRepository
     */
    private $sr;

    /**
     * @var WorkRepository
     */
    private $wr;

    /**
     * Methods.
     */

    /**
     * @param FactoryInterface          $factory
     * @param AuthorizationChecker      $ac
     * @param TokenStorageInterface     $ts
     * @param VehicleCategoryRepository $vcr
     * @param ServiceRepository         $sr
     * @param WorkRepository            $wr
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac, TokenStorageInterface $ts, VehicleCategoryRepository $vcr, ServiceRepository $sr, WorkRepository $wr)
    {
        $this->factory = $factory;
        $this->ac = $ac;
        $this->ts = $ts;
        $this->vcr = $vcr;
        $this->sr = $sr;
        $this->wr = $wr;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createTopMenu(RequestStack $requestStack)
    {
        $route = $requestStack->getCurrentRequest()->get('_route');
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
                'current' => $route == 'front_services' || $route == 'front_service_detail',
            )
        );
        $menu->addChild(
            'front_vehicles',
            array(
                'label' => 'Vehículos',
                'route' => 'front_vehicles',
                'current' => $route == 'front_vehicles' || $route == 'front_vehicle_detail' || $route == 'front_vehicles_category',
            )
        );
        $menu->addChild(
            'front_works',
            array(
                'label' => 'Trabajos',
                'route' => 'front_works',
                'current' => $route == 'front_works' || $route == 'front_work_detail',
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
     * @return ItemInterface
     */
    public function createVehicleCategoryMenu()
    {
        $menu = $this->factory->createItem('rootCategory');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked nav-yellow');
        $categories = $this->vcr->findEnabledSortedByName();

        /** @var VehicleCategory $category */
        foreach ($categories as $category) {
            if ($category->getVehicles()->count() > 0) {
                $menu->addChild(
                    $category->getSlug(),
                    array(
                        'label' => ucfirst(strtolower($category->getName())),
                        'route' => 'front_vehicles_category',
                        'routeParameters' => array(
                            'slug' => $category->getSlug(),
                        ),
                    )
                );
            }
        }

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    public function createServiceMenu()
    {
        $menu = $this->factory->createItem('rootService');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked nav-yellow');
        $services = $this->sr->findEnabledSortedByPositionAndName();

        /** @var Service $service */
        foreach ($services as $service) {
            $menu->addChild(
                $service->getSlug(),
                array(
                    'label' => ucfirst(strtolower($service->getName())),
                    'route' => 'front_service_detail',
                    'routeParameters' => array(
                        'slug' => $service->getSlug(),
                    ),
                )
            );
        }

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    public function createFooterMenu()
    {
        $menu = $this->factory->createItem('rootFooter');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked nav-yellow');
        $menu->addChild(
            'front_about',
            array(
                'label' => 'Sobre este sitio',
                'route' => 'front_about',
            )
        );
        $menu->addChild(
            'front_privacy',
            array(
                'label' => 'Privacidad',
                'route' => 'front_privacy',
            )
        );
        $menu->addChild(
            'front_sitemap',
            array(
                'label' => 'Mapa del web',
                'route' => 'front_sitemap',
            )
        );

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    public function createSitemapMenu()
    {
        $menu = $this->factory->createItem('rootSitemap');
        $menu->addChild(
            'front_homepage',
            array(
                'label' => 'Inicio',
                'route' => 'front_homepage',
            )
        );
        $serviceMenu = $menu->addChild(
            'front_services',
            array(
                'label' => 'Servicios',
                'route' => 'front_services',
            )
        );
        $services = $this->sr->findEnabledSortedByPositionAndName();
        /** @var Service $service */
        foreach ($services as $service) {
            $serviceMenu->addChild(
                $service->getSlug(),
                array(
                    'label' => ucfirst(strtolower($service->getName())),
                    'route' => 'front_service_detail',
                    'routeParameters' => array(
                        'slug' => $service->getSlug(),
                    ),
                )
            );
        }
        $vehicleMenu = $menu->addChild(
            'front_vehicles',
            array(
                'label' => 'Vehículos',
                'route' => 'front_vehicles',
            )
        );
        $vehicleCategories = $this->vcr->findEnabledSortedByName();
        /** @var VehicleCategory $vehicleCategory */
        foreach ($vehicleCategories as $vehicleCategory) {
            $vehicleMenu->addChild(
                $vehicleCategory->getSlug(),
                array(
                    'label' => ucfirst(strtolower($vehicleCategory->getName())),
                    'route' => 'front_vehicles_category',
                    'routeParameters' => array(
                        'slug' => $vehicleCategory->getSlug(),
                    ),
                )
            );
        }

        $workMenu = $menu->addChild(
            'front_works',
            array(
                'label' => 'Trabajos',
                'route' => 'front_works',
            )
        );
        $works = $this->wr->findEnabledSortedByName();
        /** @var Work $work */
        foreach ($works as $work) {
            $workMenu->addChild(
                $work->getSlug(),
                array(
                    'label' => ucfirst(strtolower($work->getName())),
                    'route' => 'front_work_detail',
                    'routeParameters' => array(
                        'slug' => $work->getSlug(),
                    ),
                )
            );
        }

        $menu->addChild(
            'front_company',
            array(
                'label' => 'Empresa',
                'route' => 'front_company',
            )
        );
        $menu->addChild(
            'front_about',
            array(
                'label' => 'Sobre este sitio',
                'route' => 'front_about',
            )
        );
        $menu->addChild(
            'front_privacy',
            array(
                'label' => 'Privacidad',
                'route' => 'front_privacy',
            )
        );
        $menu->addChild(
            'front_sitemap',
            array(
                'label' => 'Mapa del web',
                'route' => 'front_sitemap',
            )
        );

        return $menu;
    }
}
