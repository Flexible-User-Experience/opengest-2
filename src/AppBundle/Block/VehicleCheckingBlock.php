<?php

namespace AppBundle\Block;

use AppBundle\Repository\VehicleCheckingRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class VehicleCheckingBlock
 *
 * @category Block
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleCheckingBlock extends AbstractBlockService
{
    /**
     * @var VehicleCheckingRepository
     */
    private $vcr;

    /**
     * @var TokenStorage
     */
    private $tss;

    /**
     * VehicleCheckingBlock constructor.
     *
     * @param null|string $name
     * @param EngineInterface $templating
     * @param VehicleCheckingRepository $vcr
     * @param TokenStorage $tss
     */
    public function __construct($name, EngineInterface $templating, VehicleCheckingRepository $vcr, TokenStorage $tss)
    {
        parent::__construct($name, $templating);
        $this->vcr = $vcr;
        $this->tss = $tss;
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response|null $response
     *
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();

        $vehiclesInvalidAmount = $this->vcr->getItemsInvalidSinceTodayByEnterpriseAmount($this->tss->getToken()->getUser()->getDefaultEnterprise());
        $vehiclesBeforeInvalidAmount = $this->vcr->getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmount($this->tss->getToken()->getUser()->getDefaultEnterprise());

        $backgroundColor = 'bg-green';
        $content = '<h3><i class="fa fa-check-circle-o" aria-hidden="true"></i></h3><p>Tots els vehicles tenen les revisions al dia</p>';

        if ($vehiclesBeforeInvalidAmount > 0 && $vehiclesInvalidAmount > 0) {
            $backgroundColor = 'bg-red';
            $content = '<h3>'.$vehiclesInvalidAmount.'</h3><p>Vehicles tenen revisions caducades</p><p>'.$vehiclesBeforeInvalidAmount.' vehicles tenen revisions a punt de caducar</p>';
        } elseif ($vehiclesInvalidAmount > 0) {
            $backgroundColor = 'bg-red';
            $content = '<h3>'.$vehiclesInvalidAmount.'</h3><p>Vehicles tenen revisions caducades</p>';
        } elseif ($vehiclesBeforeInvalidAmount > 0) {
            $backgroundColor = 'bg-yellow';
            $content = '<h3>'.$vehiclesBeforeInvalidAmount.'</h3><p>Vehicles tenen revisions a punt de caducar</p>';
        }

        return $this->renderResponse(
            $blockContext->getTemplate(), [
                'block' => $blockContext->getBlock(),
                'settings' => $settings,
                'title' => 'Notificacions',
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
        return 'vehicle_checking';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'title' => 'Resum',
            'content' => 'Default content',
            'template' => ':Admin/Block:vehicle_checking.html.twig',
        ]);
    }

}
