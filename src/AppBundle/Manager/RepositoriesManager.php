<?php

namespace AppBundle\Manager;

use AppBundle\Repository\EnterpriseGroupBountyRepository;
use AppBundle\Repository\EnterpriseRepository;
use AppBundle\Repository\OperatorAbsenceRepository;
use AppBundle\Repository\OperatorAbsenceTypeRepository;
use AppBundle\Repository\OperatorCheckingRepository;
use AppBundle\Repository\OperatorCheckingTypeRepository;
use AppBundle\Repository\OperatorRepository;
use AppBundle\Repository\PartnerClassRepository;
use AppBundle\Repository\PartnerRepository;
use AppBundle\Repository\PartnerTypeRepository;
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
     * @var EnterpriseGroupBountyRepository
     */
    private $enterpriseGroupBountyRepository;

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
     * @var PartnerRepository
     */
    private $partnerRepository;

    /**
     * @var PartnerClassRepository
     */
    private $parterClassRepository;
    /**
     * @var PartnerTypeRepository
     */
    private $parterTypeRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository               $serviceRepository
     * @param VehicleCategoryRepository       $vehicleCategoryRepository
     * @param UserRepository                  $userRepository
     * @param OperatorRepository              $operatorRepository
     * @param EnterpriseRepository            $enterpriseRepository
     * @param EnterpriseGroupBountyRepository $enterpriseGroupBountyRepository
     * @param OperatorCheckingRepository      $operatorCheckingRepository
     * @param OperatorCheckingTypeRepository  $operatorCheckingTypeRepository
     * @param OperatorAbsenceTypeRepository   $operatorAbsenceTypeRepository
     * @param OperatorAbsenceRepository       $operatorAbsenceRepository
     * @param VehicleRepository               $vehicleRepository
     * @param VehicleCheckingTypeRepository   $vehicleCheckingTypeRepository
     * @param VehicleCheckingRepository       $vehicleCheckingRepository
     * @param PartnerRepository               $partnerRepository
     * @param PartnerClassRepository          $partnerClassRepository
     * @param PartnerTypeRepository           $partnerTyperRepository
     */
    public function __construct(ServiceRepository $serviceRepository, VehicleCategoryRepository $vehicleCategoryRepository, UserRepository $userRepository, OperatorRepository $operatorRepository, EnterpriseRepository $enterpriseRepository, EnterpriseGroupBountyRepository $enterpriseGroupBountyRepository, OperatorCheckingRepository $operatorCheckingRepository, OperatorCheckingTypeRepository $operatorCheckingTypeRepository, OperatorAbsenceTypeRepository $operatorAbsenceTypeRepository, OperatorAbsenceRepository $operatorAbsenceRepository, VehicleRepository $vehicleRepository, VehicleCheckingTypeRepository $vehicleCheckingTypeRepository, VehicleCheckingRepository $vehicleCheckingRepository, PartnerRepository $partnerRepository, PartnerClassRepository $partnerClassRepository, PartnerTypeRepository $partnerTypeRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->userRepository = $userRepository;
        $this->operatorRepository = $operatorRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->enterpriseGroupBountyRepository = $enterpriseGroupBountyRepository;
        $this->operatorCheckingRepository = $operatorCheckingRepository;
        $this->operatorCheckingTypeRepository = $operatorCheckingTypeRepository;
        $this->operatorAbsenceTypeRepository = $operatorAbsenceTypeRepository;
        $this->operatorAbsenceRepository = $operatorAbsenceRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleCheckingTypeRepository = $vehicleCheckingTypeRepository;
        $this->vehicleCheckingRepository = $vehicleCheckingRepository;
        $this->partnerRepository = $partnerRepository;
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
     * @return EnterpriseGroupBountyRepository
     */
    public function getEnterpriseGroupBountyRepository()
    {
        return $this->enterpriseGroupBountyRepository;
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

    /**
     * @return PartnerRepository
     */
    public function getPartnerRepository()
    {
        return $this->partnerRepository;
    }

    /**
     * @return PartnerClassRepository
     */
    public function getParterClassRepository()
    {
        return $this->parterClassRepository;
    }

    /**
     * @return PartnerTypeRepository
     */
    public function getParterTypeRepository()
    {
        return $this->parterTypeRepository;
    }
}
