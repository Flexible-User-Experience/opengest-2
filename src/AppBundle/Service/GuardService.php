<?php

namespace AppBundle\Service;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\Operator;
use AppBundle\Entity\OperatorChecking;
use AppBundle\Entity\Partner;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleChecking;
use AppBundle\Enum\UserRolesEnum;
use AppBundle\Security\AbstractVoter;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class GuardService.
 *
 * @category Service
 */
class GuardService
{
    /**
     * @var AuthorizationChecker
     */
    private $acs;

    /**
     * Methods.
     */

    /**
     * @param AuthorizationChecker $acs
     */
    public function __construct(AuthorizationChecker $acs)
    {
        $this->acs = $acs;
    }

    /**
     * @param Operator $operator
     *
     * @return bool
     */
    public function isOwnOperator(Operator $operator)
    {
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            return true;
        }

        return $this->acs->isGranted(AbstractVoter::ATTRIBUTES, $partner);
    }
}
