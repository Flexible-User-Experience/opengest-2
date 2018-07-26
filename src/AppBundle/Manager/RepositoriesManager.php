<?php

namespace AppBundle\Manager;

use AppBundle\Repository\EnterpriseRepository;
use AppBundle\Repository\OperatorAbsenceRepository;
use AppBundle\Repository\OperatorAbsenceTypeRepository;
use AppBundle\Repository\OperatorCheckingRepository;
use AppBundle\Repository\OperatorCheckingTypeRepository;
use AppBundle\Repository\OperatorRepository;
use AppBundle\Repository\ServiceRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\VehicleCategoryRepository;
use AppBundle\Repository\VehicleCheckingRepository;
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
     * @var EnterpriseRepository
     */
    private $enterpriseRepository;

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
     * @var VehicleCheckingRepository
     */
    private $vehicleCheckingRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository              $serviceRepository
     * @param VehicleCategoryRepository      $vehicleCategoryRepository
     * @param UserRepository                 $userRepository
     * @param OperatorRepository             $operatorRepository
     * @param EnterpriseRepository           $enterpriseRepository
     * @param OperatorCheckingRepository     $operatorCheckingRepository
     * @param OperatorCheckingTypeRepository $operatorCheckingTypeRepository
     * @param OperatorAbsenceTypeRepository  $operatorAbsenceTypeRepository
     * @param OperatorAbsenceRepository      $operatorAbsenceRepository
     * @param VehicleRepository              $vehicleRepository
     * @param VehicleCheckingTypeRepository  $vehicleCheckingTypeRepository
     * @param VehicleCheckingRepository      $vehicleCheckingRepository
     */
    public function __construct(ServiceRepository $serviceRepository, VehicleCategoryRepository $vehicleCategoryRepository, UserRepository $userRepository, OperatorRepository $operatorRepository, EnterpriseRepository $enterpriseRepository, OperatorCheckingRepository $operatorCheckingRepository, OperatorCheckingTypeRepository $operatorCheckingTypeRepository, OperatorAbsenceTypeRepository $operatorAbsenceTypeRepository, OperatorAbsenceRepository $operatorAbsenceRepository, VehicleRepository $vehicleRepository, VehicleCheckingTypeRepository $vehicleCheckingTypeRepository, VehicleCheckingRepository $vehicleCheckingRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->userRepository = $userRepository;
        $this->operatorRepository = $operatorRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->operatorCheckingRepository = $operatorCheckingRepository;
        $this->operatorCheckingTypeRepository = $operatorCheckingTypeRepository;
        $this->operatorAbsenceTypeRepository = $operatorAbsenceTypeRepository;
        $this->operatorAbsenceRepository = $operatorAbsenceRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleCheckingTypeRepository = $vehicleCheckingTypeRepository;
        $this->vehicleCheckingRepository = $vehicleCheckingRepository;
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
     * @return EnterpriseRepository
     */
    public function getEnterpriseRepository()
    {
        return $this->enterpriseRepository;
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

    /**
     * @return VehicleCheckingRepository
     */
    public function getVehicleCheckingRepository()
    {
        return $this->vehicleCheckingRepository;
    }
}
