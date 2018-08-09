<?php

namespace AppBundle\Security;

use AppBundle\Entity\OperatorChecking;
use AppBundle\Entity\User;
use AppBundle\Security\Traits\VoteOnAttributeTrait;

/**
 * Class OperatorCheckingVoter.
 */
class OperatorCheckingVoter extends AbstractVoter
{
    use VoteOnAttributeTrait;

    /**
     * @param string           $attribute
     * @param OperatorChecking $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof OperatorChecking && in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * @param User|null|object $user
     * @param OperatorChecking $oc
     *
     * @return bool
     */
    private function isOwner(?User $user, OperatorChecking $oc)
    {
        if (!$user) {
            return false;
        }

        return $oc->getOperator()->getEnterprise()->getId() == $user->getLoggedEnterprise()->getId();
    }
}