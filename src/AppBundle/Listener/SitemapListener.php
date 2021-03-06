<?php

namespace AppBundle\Listener;

use AppBundle\Menu\FrontendMenuBuilder;
use Knp\Menu\MenuItem;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
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
     *
     * @throws \Exception
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || 'default' == $section) {
            $sitemap = $this->menuBuilder->createSitemapMenu();
            /** @var MenuItem $item */
            foreach ($sitemap->getIterator() as $item) {
                if ($item->getExtra('updated_at')) {
                    $event
                        ->getUrlContainer()
                        ->addUrl($this->makeUrlConcrete($item->getName(), 1, $item->getExtra('updated_at')), 'default');
                } else {
                    $event
                        ->getUrlContainer()
                        ->addUrl($this->makeUrlConcrete($item->getName()), 'default');
                }
                if (count($item->getChildren()) > 0) {
                    /** @var MenuItem $child */
                    foreach ($item->getChildren() as $child) {
                        if ($child->getExtra('updated_at')) {
                            $event
                                ->getUrlContainer()
                                ->addUrl($this->makeUrlConcrete($child->getName(), 0.8, $child->getExtra('updated_at')), 'default');
                        } else {
                            $event
                                ->getUrlContainer()
                                ->addUrl($this->makeUrlConcrete($child->getName(), 0.8), 'default');
                        }
                        if (count($child->getChildren()) > 0) {
                            /** @var MenuItem $grandchild */
                            foreach ($child->getChildren() as $grandchild) {
                                if ($grandchild->getExtra('updated_at')) {
                                    $event
                                        ->getUrlContainer()
                                        ->addUrl($this->makeUrlConcrete($grandchild->getName(), 0.5, $grandchild->getExtra('updated_at')), 'default');
                                } else {
                                    $event
                                        ->getUrlContainer()
                                        ->addUrl($this->makeUrlConcrete($grandchild->getName(), 0.5), 'default');
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string         $url
     * @param int            $priority
     * @param \DateTime|null $date
     *
     * @return UrlConcrete
     *
     * @throws \Exception
     */
    private function makeUrlConcrete($url, $priority = 1, $date = null)
    {
        return new UrlConcrete(
            $url,
            null === $date ? new \DateTime() : $date,
            UrlConcrete::CHANGEFREQ_WEEKLY,
            $priority
        );
    }
}
