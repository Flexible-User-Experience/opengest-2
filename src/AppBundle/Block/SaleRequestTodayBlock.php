<?php

namespace AppBundle\Block;

use AppBundle\Repository\Partner\PartnerOrderRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class SaleRequestTodayBlock.
 *
 * @category Block
 */
class SaleRequestTodayBlock extends AbstractBlockService
{
    /**
     * @var PartnerOrderRepository
     */
    private $por;

    /**
     * Methods.
     */

    /**
     * @param null|string            $name
     * @param EngineInterface        $templating
     * @param PartnerOrderRepository $por
     */
    public function __construct($name, EngineInterface $templating, PartnerOrderRepository $por)
    {
        parent::__construct($name, $templating);
        $this->por = $por;
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
