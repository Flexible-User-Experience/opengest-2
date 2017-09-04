<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class EnterpriseRepository.
 *
 * @category    Repository
 *
 * @author      Wils Iglesias <wiglesias83@gmail.com>
 */
class EnterpriseRepository extends EntityRepository
{
    public function getUserEnterpriseQB(User $user)
    {
        return $this->createQueryBuilder('e');
    }
}
