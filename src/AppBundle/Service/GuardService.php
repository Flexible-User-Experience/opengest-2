<?php

namespace AppBundle\Service;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\Operator;
use AppBundle\Entity\OperatorChecking;
use AppBundle\Entity\User;
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
        return $this->acs->isGranted('ROLE_ADMIN') || $operator->getEnterprise()->getId() == $this->getDefaultEnterpriseId() ? true : false;
    }

    /**
     * @param OperatorChecking $oc
     *
     * @return bool
     */
    public function isOwnOperatorCheking(OperatorChecking $oc)
    {
        return $this->acs->isGranted('ROLE_ADMIN') || $oc->getOperator()->getEnterprise()->getId() == $this->getDefaultEnterpriseId() ? true : false;
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

        $result = false;
        $users = $enterprise->getUsers();
        /** @var User $user */
        foreach ($users as $user) {
            if ($user->getId() == $this->tss->getToken()->getUser()->getId()) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
