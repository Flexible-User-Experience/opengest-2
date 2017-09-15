<?php

namespace AppBundle\Service;

use AppBundle\Entity\Operator;
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
     * @param Operator $operator
     *
     * @return bool
     */
    public function isOwnOperator(Operator $operator)
    {
        if ($operator->getEnterprise()->getId() == $this->tss->getToken()->getUser()->getDefaultEnterprise()->getId()) {
            return true;
        }

        return false;
    }
}
