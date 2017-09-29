<?php

namespace AppBundle\Block;

use AppBundle\Repository\OperatorAbsenceRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class OperatorAbsenceBlock.
 *
 * @category Block
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class OperatorAbsenceBlock extends AbstractBlockService
{
    /**
     * @var OperatorAbsenceRepository
     */
    private $oar;

    /**
     * @var TokenStorage
     */
    private $tss;

    /**
     * Methods.
     */

    /**
     * OperatorAbsenceBlock constructor.
     *
     * @param null|string               $name
     * @param EngineInterface           $templating
     * @param OperatorAbsenceRepository $oar
     * @param TokenStorage              $tss
     */
    public function __construct($name, EngineInterface $templating, OperatorAbsenceRepository $oar, TokenStorage $tss)
    {
        parent::__construct($name, $templating);
        $this->oar = $oar;
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

        $operatorsAbsentAmount = $this->oar->getItemsAbsenceTodayAmount($this->tss->getToken()->getUser()->getDefaultEnterprise());
        $backgroundColor = 'bg-green';
        $content = '<h3><i class="fa fa-check-circle-o" aria-hidden="true"></i></h3><p>Avui tots els operaris estan disponibles</p>';

        if ($operatorsAbsentAmount > 0) {
            $backgroundColor = 'bg-red';
            $content = '<h3>'.$operatorsAbsentAmount.'</h3><p>operaris avui no estan disponibles</p>';
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
     * @return string
     */
    public function getName()
    {
        return 'operator_absence';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'title' => 'Resum',
            'content' => 'Default content',
            'template' => ':Admin/Block:operator_absence.html.twig',
        ));
    }
}
