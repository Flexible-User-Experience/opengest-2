<?php

namespace AppBundle\Security;

use AppBundle\Entity\Operator;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Security\Traits\VoteOnAttributeTrait;

/**
 * Class VehicleVoter.
 */
class VehicleVoter extends AbstractVoter
{
    use VoteOnAttributeTrait;

    /**
     * @param string  $attribute
     * @param Vehicle $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Operator && in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * @param User|null|object $user
     * @param Vehicle          $vehicle
     *
     * @return bool
     */
    private function isOwner(?User $user, Vehicle $vehicle)
    {
        if (!$user) {
            return false;
        }

        return $vehicle->getEnterprise()->getId() == $user->getLoggedEnterprise()->getId();
    }
}
