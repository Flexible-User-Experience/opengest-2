<?php

namespace AppBundle\Manager;

use AppBundle\Repository\OperatorRepository;
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
     * @var OperatorRepository
     */
    private $operatorRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository         $serviceRepository
     * @param VehicleCategoryRepository $vehicleCategoryRepository
     * @param UserRepository            $userRepository
     * @param OperatorRepository        $operatorRepository
     */
    public function __construct(ServiceRepository $serviceRepository, VehicleCategoryRepository $vehicleCategoryRepository, UserRepository $userRepository, OperatorRepository $operatorRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->userRepository = $userRepository;
        $this->operatorRepository = $operatorRepository;
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

    /**
     * @return OperatorRepository
     */
    public function getOperatorRepository()
    {
        return $this->operatorRepository;
    }
}
