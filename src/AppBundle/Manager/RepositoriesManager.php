<?php

namespace AppBundle\Manager;

use AppBundle\Repository\ServiceRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\VehicleCategoryRepository;

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
     * @var VehicleCategoryRepository
     */
    private $vehicleCategoryRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository         $serviceRepository
     * @param VehicleCategoryRepository $vehicleCategoryRepository
     * @param UserRepository            $userRepository
     */
    public function __construct(ServiceRepository $serviceRepository, VehicleCategoryRepository $vehicleCategoryRepository, UserRepository $userRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return ServiceRepository
     */
    public function getServiceRepository()
    {
        return $this->serviceRepository;
    }

    /**
     * @return VehicleCategoryRepository
     */
    public function getVehicleCategoryRepository()
    {
        return $this->vehicleCategoryRepository;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }
}
