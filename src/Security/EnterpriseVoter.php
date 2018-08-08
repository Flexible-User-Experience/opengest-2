<?php

namespace AppBundle\Security;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\User;
use AppBundle\Service\GuardService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class EnterpriseVoter.
 */
class EnterpriseVoter extends AbstractVoter
{
    /**
     * @var GuardService
     */
    private $gs;

    /**
     * EnterpriseVoter constructor.
     *
     * @param GuardService $gs
     */
    public function __construct(GuardService $gs)
    {
        $this->gs = $gs;
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
     * @param Enterprise       $subject
     *
     * @return bool
     */
    private function isOwner(?User $user, Enterprise $subject)
    {
        if (!$user) {
            return false;
        }

        return $this->gs->isOwnEnterprise($subject);
    }
}
