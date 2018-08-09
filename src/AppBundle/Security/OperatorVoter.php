<?php

namespace AppBundle\Security;

use AppBundle\Entity\Operator;
use AppBundle\Entity\User;

/**
 * Class EnterpriseVoter.
 */
class OperatorVoter extends AbstractVoter
{
    /**
     * @param string   $attribute
     * @param Operator $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Operator && in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * @param User|null|object $user
     * @param Operator         $operator
     *
     * @return bool
     */
    private function isOwner(?User $user, Operator $operator)
    {
        if (!$user) {
            return false;
        }

        return $operator->getEnterprise()->getId() == $user->getLoggedEnterprise()->getId();
    }
}
