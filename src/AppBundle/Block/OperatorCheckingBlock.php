<?php

namespace AppBundle\Block;

use AppBundle\Repository\OperatorCheckingRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class OperatorCheckingBlock.
 *
 * @category Block
 */
class OperatorCheckingBlock extends AbstractBlockService
{
    /**
     * @var OperatorCheckingRepository
     */
    private $ocr;

    /**
     * @var TokenStorage
     */
    private $tss;

    /**
     * Methods.
     */

    /**
     * OperatorCheckingBlock constructor.
     *
     * @param null|string                $name
     * @param EngineInterface            $templating
     * @param OperatorCheckingRepository $ocr
     * @param TokenStorage               $tss
     */
    public function __construct($name, EngineInterface $templating, OperatorCheckingRepository $ocr, TokenStorage $tss)
    {
        parent::__construct($name, $templating);
        $this->ocr = $ocr;
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

        $backgroundColor = 'bg-green';
        $content = '<p>Tots els operaris tenen les revisions al dia</p>';

        $opertaorsInvailids = $this->ocr->getItemsInvalid();
        if (count($opertaorsInvailids) > 0) {
            $backgroundColor = 'bg-red';
            $content = '<p>'.count($opertaorsInvailids).' operaris tenen revisions caducades</p>';
        }

        return $this->renderResponse(
            $blockContext->getTemplate(),
            array(
                'block' => $blockContext->getBlock(),
                'settings' => $settings,
                'title' => 'Notificacions',
                'background' => $backgroundColor,
                'content' => $content,
            ),
            $response
        );
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return 'operator_checking';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'title' => 'Resum',
            'content' => 'Default content',
            'template' => ':Admin/Block:operator_checking.html.twig',
        ));
    }
}
