<?php

namespace AppBundle\Manager;

use AppBundle\Repository\ServiceRepository;

/**
 * Class RepositoriesManager.
 *
 * @category Manager
 *
 * @author   David Romaní <david@flux.cat>
 */
class RepositoriesManager
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @return ServiceRepository
     */
    public function getServiceRepository()
    {
        return $this->serviceRepository;
    }
}
