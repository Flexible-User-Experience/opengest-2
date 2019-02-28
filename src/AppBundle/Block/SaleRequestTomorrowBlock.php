<?php

namespace AppBundle\Block;

use AppBundle\Repository\Sale\SaleRequestRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class SaleRequestTomorrowBlock.
 *
 * @category Block
 */
class SaleRequestTomorrowBlock extends AbstractBlockService
{
    /**
     * @var SaleRequestRepository
     */
    private $srr;

    /**
     * @var TokenStorage
     */
    private $tss;

    /**
     * Methods.
     */

    /**
     * @param null|string           $name
     * @param EngineInterface       $templating
     * @param SaleRequestRepository $srr
     * @param TokenStorage          $tss
     */
    public function __construct($name, EngineInterface $templating, SaleRequestRepository $srr, TokenStorage $tss)
    {
        parent::__construct($name, $templating);
        $this->srr = $srr;
        $this->tss = $tss;
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response|null         $response
     *
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $backgroundColor = 'bg-light-blue';
        $tomorroySaleRequests = array(); // TODO

        return $this->renderResponse(
            $blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
            'title' => 'admin.dashboard.tomorrow',
            'background' => $backgroundColor,
            'content' => $tomorroySaleRequests,
        ],
            $response
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sale_request_today';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'title' => 'admin.dashboard.tomorrow',
            'content' => 'Default content',
            'template' => ':Admin/Block:sale_requests.html.twig',
        ]);
    }
}
