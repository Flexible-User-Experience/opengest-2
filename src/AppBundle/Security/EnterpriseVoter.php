<?php

namespace AppBundle\Security;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class EnterpriseVoter.
 */
class EnterpriseVoter extends AbstractVoter
{
    /**
     * @param string     $attribute
     * @param Enterprise $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Enterprise && in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * @param string         $attribute
     * @param Enterprise     $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case self::EDIT:
                return $this->isOwner($token->getUser(), $subject);
        }

        throw new \LogicException('Invalid attribute: '.$attribute);
    }

    /**
     * @param User|null|object $user
     * @param Enterprise       $enterprise
     *
     * @return bool
     */
    private function isOwner(?User $user, Enterprise $enterprise)
    {
        if (!$user) {
            return false;
        }

        $result = false;
        $users = $enterprise->getUsers();
        /* @var User $enterpriseUser */
        foreach ($users as $enterpriseUser) {
            if ($user->getId() == $enterpriseUser->getId()) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
