<?php

namespace AppBundle\Manager;

use AppBundle\Repository\ActivityLineRepository;
use AppBundle\Repository\CityRepository;
use AppBundle\Repository\CollectionDocumentTypeRepository;
use AppBundle\Repository\EnterpriseGroupBountyRepository;
use AppBundle\Repository\EnterpriseRepository;
use AppBundle\Repository\EnterpriseTransferAccountRepository;
use AppBundle\Repository\EnterpriseHolidaysRepository;
use AppBundle\Repository\OperatorAbsenceRepository;
use AppBundle\Repository\OperatorAbsenceTypeRepository;
use AppBundle\Repository\OperatorCheckingRepository;
use AppBundle\Repository\OperatorCheckingTypeRepository;
use AppBundle\Repository\OperatorRepository;
use AppBundle\Repository\PartnerBuildingSiteRepository;
use AppBundle\Repository\PartnerClassRepository;
use AppBundle\Repository\PartnerOrderRepository;
use AppBundle\Repository\PartnerRepository;
use AppBundle\Repository\PartnerTypeRepository;
use AppBundle\Repository\SaleDeliveryNoteRepository;
use AppBundle\Repository\SaleInvoiceSeriesRepository;
use AppBundle\Repository\SaleRequestRepository;
use AppBundle\Repository\SaleTariffRepository;
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
     * @var EnterpriseTransferAccountRepository
     */
    private $enterpriseTransferAccountRepository;

    /**
     * @var EnterpriseHolidaysRepository
     */
    private $enterpriseHolidaysRepository;

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
    private $partnerClassRepository;

    /**
     * @var PartnerTypeRepository
     */
    private $partnerTypeRepository;

    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var SaleTariffRepository
     */
    private $saleTariffRepository;

    /**
     * @var PartnerBuildingSiteRepository
     */
    private $partnerBuildingSiteRepository;

    /**
     * @var PartnerOrderRepository
     */
    private $partnerOrderRepository;

    /**
     * @var CollectionDocumentTypeRepository
     */
    private $collectionDocumentTypeRepository;

    /**
     * @var ActivityLineRepository
     */
    private $activityLineRepository;

    /**
     * @var SaleInvoiceSeriesRepository
     */
    private $saleInvoiceSeriesRepository;

    /**
     * @var SaleRequestRepository
     */
    private $saleRequestRepository;

    /**
     * @var SaleDeliveryNoteRepository
     */
    private $saleDeliveryNoteRepository;

    /**
     * Methods.
     */

    /**
     * RepositoriesManager constructor.
     *
     * @param ServiceRepository                   $serviceRepository
     * @param VehicleCategoryRepository           $vehicleCategoryRepository
     * @param UserRepository                      $userRepository
     * @param OperatorRepository                  $operatorRepository
     * @param EnterpriseRepository                $enterpriseRepository
     * @param EnterpriseGroupBountyRepository     $enterpriseGroupBountyRepository
     * @param EnterpriseTransferAccountRepository $enterpriseTransferAccountRepository
     * @param EnterpriseHolidaysRepository        $enterpriseHolidaysRepository
     * @param OperatorCheckingRepository          $operatorCheckingRepository
     * @param OperatorCheckingTypeRepository      $operatorCheckingTypeRepository
     * @param OperatorAbsenceTypeRepository       $operatorAbsenceTypeRepository
     * @param OperatorAbsenceRepository           $operatorAbsenceRepository
     * @param VehicleRepository                   $vehicleRepository
     * @param VehicleCheckingTypeRepository       $vehicleCheckingTypeRepository
     * @param VehicleCheckingRepository           $vehicleCheckingRepository
     * @param PartnerRepository                   $partnerRepository
     * @param PartnerClassRepository              $partnerClassRepository
     * @param PartnerTypeRepository               $partnerTypeRepository
     * @param CityRepository                      $cityRepository
     * @param SaleTariffRepository                $saleTariffRepository
     * @param PartnerBuildingSiteRepository       $partnerBuildingSiteRepository
     * @param PartnerOrderRepository              $partnerOrderRepository
     * @param CollectionDocumentTypeRepository    $collectionDocumentTypeRepository
     * @param ActivityLineRepository              $activityLineRepository
     * @param SaleInvoiceSeriesRepository         $saleInvoiceSeriesRepository
     * @param SaleRequestRepository               $saleRequestRepository
     * @param SaleDeliveryNoteRepository          $saleDeliveryNoteRepository
     */
    public function __construct(
        ServiceRepository $serviceRepository,
        VehicleCategoryRepository $vehicleCategoryRepository,
        UserRepository $userRepository,
        OperatorRepository $operatorRepository,
        EnterpriseRepository $enterpriseRepository,
        EnterpriseGroupBountyRepository $enterpriseGroupBountyRepository,
        EnterpriseTransferAccountRepository $enterpriseTransferAccountRepository,
        EnterpriseHolidaysRepository $enterpriseHolidaysRepository,
        OperatorCheckingRepository $operatorCheckingRepository,
        OperatorCheckingTypeRepository $operatorCheckingTypeRepository,
        OperatorAbsenceTypeRepository $operatorAbsenceTypeRepository,
        OperatorAbsenceRepository $operatorAbsenceRepository,
        VehicleRepository $vehicleRepository,
        VehicleCheckingTypeRepository $vehicleCheckingTypeRepository,
        VehicleCheckingRepository $vehicleCheckingRepository,
        PartnerRepository $partnerRepository,
        PartnerClassRepository $partnerClassRepository,
        PartnerTypeRepository $partnerTypeRepository,
        CityRepository $cityRepository,
        SaleTariffRepository $saleTariffRepository,
        PartnerBuildingSiteRepository $partnerBuildingSiteRepository,
        PartnerOrderRepository $partnerOrderRepository,
        CollectionDocumentTypeRepository $collectionDocumentTypeRepository,
        ActivityLineRepository $activityLineRepository,
        SaleInvoiceSeriesRepository $saleInvoiceSeriesRepository,
        SaleRequestRepository $saleRequestRepository,
        SaleDeliveryNoteRepository $saleDeliveryNoteRepository
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->userRepository = $userRepository;
        $this->operatorRepository = $operatorRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->enterpriseGroupBountyRepository = $enterpriseGroupBountyRepository;
        $this->enterpriseTransferAccountRepository = $enterpriseTransferAccountRepository;
        $this->enterpriseHolidaysRepository = $enterpriseHolidaysRepository;
        $this->operatorCheckingRepository = $operatorCheckingRepository;
        $this->operatorCheckingTypeRepository = $operatorCheckingTypeRepository;
        $this->operatorAbsenceTypeRepository = $operatorAbsenceTypeRepository;
        $this->operatorAbsenceRepository = $operatorAbsenceRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleCheckingTypeRepository = $vehicleCheckingTypeRepository;
        $this->vehicleCheckingRepository = $vehicleCheckingRepository;
        $this->partnerRepository = $partnerRepository;
        $this->partnerClassRepository = $partnerClassRepository;
        $this->partnerTypeRepository = $partnerTypeRepository;
        $this->cityRepository = $cityRepository;
        $this->saleTariffRepository = $saleTariffRepository;
        $this->partnerBuildingSiteRepository = $partnerBuildingSiteRepository;
        $this->partnerOrderRepository = $partnerOrderRepository;
        $this->collectionDocumentTypeRepository = $collectionDocumentTypeRepository;
        $this->activityLineRepository = $activityLineRepository;
        $this->saleInvoiceSeriesRepository = $saleInvoiceSeriesRepository;
        $this->saleRequestRepository = $saleRequestRepository;
        $this->saleDeliveryNoteRepository = $saleDeliveryNoteRepository;
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
     * @return EnterpriseTransferAccountRepository
     */
    public function getEnterpriseTransferAccountRepository()
    {
        return $this->enterpriseTransferAccountRepository;
    }

    /**
     * @return EnterpriseHolidaysRepository
     */
    public function getEnterpriseHolidaysRepository()
    {
        return $this->enterpriseHolidaysRepository;
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
    public function getPartnerClassRepository()
    {
        return $this->partnerClassRepository;
    }

    /**
     * @return CityRepository
     */
    public function getCityRepository()
    {
        return $this->cityRepository;
    }

    /**
     * @return PartnerTypeRepository
     */
    public function getPartnerTypeRepository()
    {
        return $this->partnerTypeRepository;
    }

    /**
     * @return SaleTariffRepository
     */
    public function getSaleTariffRepository()
    {
        return $this->saleTariffRepository;
    }

    /**
     * @return PartnerBuildingSiteRepository
     */
    public function getPartnerBuildingSiteRepository()
    {
        return $this->partnerBuildingSiteRepository;
    }

    /**
     * @return PartnerOrderRepository
     */
    public function getPartnerOrderRepository()
    {
        return $this->partnerOrderRepository;
    }

    /**
     * @return CollectionDocumentTypeRepository
     */
    public function getCollectionDocumentTypeRepository()
    {
        return $this->collectionDocumentTypeRepository;
    }

    /**
     * @return ActivityLineRepository
     */
    public function getActivityLineRepository()
    {
        return $this->activityLineRepository;
    }

    /**
     * @return SaleInvoiceSeriesRepository
     */
    public function getSaleInvoiceSeriesRepository()
    {
        return $this->saleInvoiceSeriesRepository;
    }

    /**
     * @return SaleRequestRepository
     */
    public function getSaleRequestRepository()
    {
        return $this->saleRequestRepository;
    }

    /**
     * @return SaleDeliveryNoteRepository
     */
    public function getSaleDeliveryNoteRepository()
    {
        return $this->saleDeliveryNoteRepository;
    }
}
