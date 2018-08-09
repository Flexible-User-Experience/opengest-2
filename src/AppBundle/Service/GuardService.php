<?php

namespace AppBundle\Service;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\Operator;
use AppBundle\Entity\OperatorChecking;
use AppBundle\Entity\Partner;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleChecking;
use AppBundle\Security\AbstractVoter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class GuardService.
 *
 * @category Service
 */
class GuardService
{
    /**
     * @var TokenStorage
     */
    private $tss;

    /**
     * @var AuthorizationChecker
     */
    private $acs;

    /**
     * Methods.
     */

    /**
     * GuardService constructor.
     *
     * @param TokenStorage         $tss
     * @param AuthorizationChecker $acs
     */
    public function __construct(TokenStorage $tss, AuthorizationChecker $acs)
    {
        $this->tss = $tss;
        $this->acs = $acs;
    }

    /**
     * @return int
     */
    private function getDefaultEnterpriseId()
    {
        return $this->tss->getToken()->getUser()->getDefaultEnterprise()->getId();
    }

    /**
     * @param Operator $operator
     *
     * @return bool
     */
    public function isOwnOperator(Operator $operator)
    {
        if ($this->acs->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $this->acs->isGranted(AbstractVoter::ATTRIBUTES, $operator);
    }

    /**
     * @param OperatorChecking $oc
     *
     * @return bool
     */
    public function isOwnOperatorCheking(OperatorChecking $oc)
    {
        if ($this->acs->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $this->acs->isGranted(AbstractVoter::ATTRIBUTES, $oc);
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return bool
     */
    public function isOwnEnterprise(Enterprise $enterprise)
    {
        if ($this->acs->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $this->acs->isGranted(AbstractVoter::ATTRIBUTES, $enterprise);
    }

    /**
     * @param Vehicle $vehicle
     *
     * @return bool
     */
    public function isOwnVehicle(Vehicle $vehicle)
    {
        if ($this->acs->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $this->acs->isGranted(AbstractVoter::ATTRIBUTES, $vehicle);
    }

    /**
     * @param VehicleChecking $vc
     *
     * @return bool
     */
    public function isOwnVehicleChecking(VehicleChecking $vc)
    {
//        return $this->acs->isGranted('ROLE_ADMIN') || $vc->getVehicle()->getEnterprise()->getId() == $this->getDefaultEnterpriseId() ? true : false;
        if ($this->acs->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $this->acs->isGranted(AbstractVoter::ATTRIBUTES, $vc);
    }

    /**
     * @param Partner $partner
     *
     * @return bool
     */
    public function isOwnPartner(Partner $partner)
    {
        return $this->acs->isGranted('ROLE_ADMIN') || $partner->getEnterprise()->getId() == $this->getDefaultEnterpriseId() ? true : false;
    }
}
