<?php

namespace AppBundle\Security;

use AppBundle\Entity\Setting\User;
use AppBundle\Entity\Vehicle\VehicleChecking;
use AppBundle\Security\Traits\VoteOnAttributeTrait;

/**
 * Class VehicleCheckingVoter.
 */
class VehicleCheckingVoter extends AbstractVoter
{
    use VoteOnAttributeTrait;

    /**
     * @param string          $attribute
     * @param VehicleChecking $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof VehicleChecking && in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * @param User|null|object $user
     * @param VehicleChecking  $vc
     *
     * @return bool
     */
    private function isOwner(?User $user, VehicleChecking $vc)
    {
        if (!$user) {
            return false;
        }

        return $vc->getVehicle()->getEnterprise()->getId() == $user->getLoggedEnterprise()->getId();
    }
}
