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
 * Class SaleRequestTodayBlock.
 *
 * @category Block
 */
class SaleRequestTodayBlock extends AbstractBlockService
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
     *
     * @throws \Exception
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $backgroundColor = 'bg-light-blue';
        $todaySaleRequests = $this->srr->getTodayFilteredByEnterpriseEnabledSortedByRequestDate($this->tss->getToken()->getUser()->getDefaultEnterprise());
        $content = '<h3><i class="fa fa-list" aria-hidden="true"></i> Avui</h3><p>Llistat de peticions en curs durant el dia d\'avui<br><br>(...)</p>';

        return $this->renderResponse(
            $blockContext->getTemplate(), [
                'block' => $blockContext->getBlock(),
                'settings' => $settings,
                'title' => 'Today',
                'background' => $backgroundColor,
                'content' => $content,
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
            'title' => 'Today',
            'content' => 'Default content',
            'template' => ':Admin/Block:sale_requests.html.twig',
        ]);
    }
}
