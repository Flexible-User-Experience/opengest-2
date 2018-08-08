<?php

namespace AppBundle\Security;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Class EnterpriseVoter.
 */
class EnterpriseVoter extends AbstractVoter
{
    /**
     * @param TokenInterface $token
     * @param Enterprise     $enterprise
     *
     * @return bool
     */
    public function isGranted(TokenInterface $token, Enterprise $enterprise)
    {
        $vote = $this->vote($token, $enterprise, self::ATTRIBUTES);

        return VoterInterface::ACCESS_GRANTED == $vote;
    }

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
        /** @var User $user */
        foreach ($users as $user) {
            if ($user->getId() == $user->getId()) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
