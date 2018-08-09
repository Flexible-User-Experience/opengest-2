<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class AbstractVoter.
 */
abstract class AbstractVoter extends Voter
{
    public const EDIT = 'edit';

    public const ATTRIBUTES = [
        self::EDIT,
    ];

    /**
     * @param string         $attribute
     * @param object         $subject
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
}
