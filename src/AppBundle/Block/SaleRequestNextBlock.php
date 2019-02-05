<?php

namespace AppBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SaleRequestNextBlock.
 *
 * @category Block
 *
 * @author   David Romaní <david@flux.cat>
 */
class SaleRequestNextBlock extends AbstractBlockService
{
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
        $backgroundColor = 'bg-black';
        $content = '<h3><i class="fa fa-list" aria-hidden="true"></i></h3><p>Llistat de peticions pendents</p>';

        return $this->renderResponse(
            $blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
            'title' => 'Next',
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
            'title' => 'Next',
            'content' => 'Default content',
            'template' => ':Admin/Block:sale_requests.html.twig',
        ]);
    }
}
