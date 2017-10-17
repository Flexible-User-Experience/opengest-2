<?php

namespace AppBundle\Manager;

use AppBundle\Repository\OperatorAbsenceRepository;
use AppBundle\Repository\OperatorAbsenceTypeRepository;
use AppBundle\Repository\OperatorCheckingRepository;
use AppBundle\Repository\OperatorCheckingTypeRepository;
use AppBundle\Repository\OperatorRepository;
use AppBundle\Repository\ServiceRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\VehicleCategoryRepository;
use AppBundle\Repository\VehicleCheckingTypeRepository;
use AppBundle\Repository\VehicleRepository;

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
     * @var OperatorCheckingRepository
     */
    private $operatorCheckingRepository;

    /**
     * @var OperatorCheckingTypeRepository
     */
    private $operatorCheckingTypeRepository;

    /**
     * @var OperatorAbsenceTypeRepository
     */
    private $operatorAbsenceTypeRepository;

    /**
     * @var OperatorAbsenceRepository
     */
    private $operatorAbsenceRepository;

    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * @var VehicleCheckingTypeRepository
     */
    private $vehicleCheckingTypeRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository $serviceRepository
     * @param VehicleCategoryRepository $vehicleCategoryRepository
     * @param UserRepository $userRepository
     * @param OperatorRepository $operatorRepository
     * @param OperatorCheckingRepository $operatorCheckingRepository
     * @param OperatorCheckingTypeRepository $operatorCheckingTypeRepository
     * @param OperatorAbsenceTypeRepository $operatorAbsenceTypeRepository
     * @param OperatorAbsenceRepository $operatorAbsenceRepository
     * @param VehicleRepository $vehicleRepository
     * @param VehicleCheckingTypeRepository $vehicleCheckingTypeRepository
     */
    public function __construct(ServiceRepository $serviceRepository, VehicleCategoryRepository $vehicleCategoryRepository, UserRepository $userRepository, OperatorRepository $operatorRepository, OperatorCheckingRepository $operatorCheckingRepository, OperatorCheckingTypeRepository $operatorCheckingTypeRepository, OperatorAbsenceTypeRepository $operatorAbsenceTypeRepository, OperatorAbsenceRepository $operatorAbsenceRepository, VehicleRepository $vehicleRepository, VehicleCheckingTypeRepository $vehicleCheckingTypeRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->userRepository = $userRepository;
        $this->operatorRepository = $operatorRepository;
        $this->operatorCheckingRepository = $operatorCheckingRepository;
        $this->operatorCheckingTypeRepository = $operatorCheckingTypeRepository;
        $this->operatorAbsenceTypeRepository = $operatorAbsenceTypeRepository;
        $this->operatorAbsenceRepository = $operatorAbsenceRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleCheckingTypeRepository = $vehicleCheckingTypeRepository;
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

    /**
     * @return OperatorCheckingRepository
     */
    public function getOperatorCheckingRepository()
    {
        return $this->operatorCheckingRepository;
    }

    /**
     * @return OperatorCheckingTypeRepository
     */
    public function getOperatorCheckingTypeRepository()
    {
        return $this->operatorCheckingTypeRepository;
    }

    /**
     * @return OperatorAbsenceRepository
     */
    public function getOperatorAbsenceRepository()
    {
        return $this->getOperatorAbsenceRepository();
    }

    /**
     * @return OperatorAbsenceTypeRepository
     */
    public function getOperatorAbsenceTypeRepository()
    {
        return $this->operatorAbsenceTypeRepository;
    }

    /**
     * @return VehicleRepository
     */
    public function getVehicleRepository()
    {
        return $this->vehicleRepository;
    }

    /**
     * @return VehicleCheckingTypeRepository
     */
    public function getVehicleCheckingTypeRepository()
    {
        return $this->vehicleCheckingTypeRepository;
    }
}
