<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * Class User.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="admin_user")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise")
     */
    private $defaultEnterprise;

    /**
     * Methods.
     */

    /**
     * Get id.
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Enterprise
     */
    public function getDefaultEnterprise()
    {
        return $this->defaultEnterprise;
    }

    /**
     * @param Enterprise $defaultEnterprise
     *
     * @return User
     */
    public function setDefaultEnterprise($defaultEnterprise)
    {
        $this->defaultEnterprise = $defaultEnterprise;

        return $this;
    }
}
