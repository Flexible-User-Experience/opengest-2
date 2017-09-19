<?php

namespace AppBundle\Service;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\Operator;
use AppBundle\Entity\OperatorChecking;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

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
     * GuardService constructor.
     *
     * @param TokenStorage $tss
     */
    public function __construct(TokenStorage $tss)
    {
        $this->tss = $tss;
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
        if ($operator->getEnterprise()->getId() == $this->getDefaultEnterpriseId()) {
            return true;
        }

        return false;
    }

    /**
     * @param OperatorChecking $oc
     *
     * @return bool
     */
    public function isOwnOperatorCheking(OperatorChecking $oc)
    {
        if ($oc->getOperator()->getEnterprise()->getId() == $this->getDefaultEnterpriseId()) {
            return true;
        }

        return false;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return bool
     */
    public function isOwnEnterprise(Enterprise $enterprise)
    {
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
