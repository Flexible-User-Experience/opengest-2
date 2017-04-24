<?php

namespace AppBundle\Listener;

use AppBundle\Menu\FrontendMenuBuilder;
use Knp\Menu\MenuItem;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SitemapListener.
 */
class SitemapListener implements SitemapListenerInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var FrontendMenuBuilder
     */
    private $menuBuilder;

    /**
     * Methods.
     */

    /**
     * SitemapListener constructor.
     *
     * @param RouterInterface     $router
     * @param FrontendMenuBuilder $menuItem
     */
    public function __construct(RouterInterface $router, FrontendMenuBuilder $menuItem)
    {
        $this->router = $router;
        $this->menuBuilder = $menuItem;
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            $sitemap = $this->menuBuilder->createSitemapMenu();
            /** @var MenuItem $item */
            foreach ($sitemap->getIterator() as $item) {
                $url = $this->router->generate(
                    'front_homepage',
                    array(
                        'slug' => $item->getUri(),
                    ),
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
//                $item->getUri();
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default');
            }
        }
    }

    /**
     * @param string $routeName
     *
     * @return string
     */
    private function makeUrl($routeName)
    {
        return $this->router->generate(
            $routeName, array(), UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * @param string         $url
     * @param int            $priority
     * @param \DateTime|null $date
     *
     * @return UrlConcrete
     */
    private function makeUrlConcrete($url, $priority = 1, $date = null)
    {
        return new UrlConcrete(
            $url,
            $date === null ? new \DateTime() : $date,
            UrlConcrete::CHANGEFREQ_WEEKLY,
            $priority
        );
    }
}
