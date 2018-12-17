<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Operator;
use AppBundle\Entity\SaleRequest;
use AppBundle\Entity\SaleTariff;
use AppBundle\Entity\Vehicle;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

/**
 * Class SaleRequestAdmin.
 *
 * @category    Admin
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class SaleRequestAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Petició';
    protected $baseRoutePattern = 'vendes/peticio';
    protected $datagridValues = array(
        '_sort_by' => 'requestDate',
        '_sort_order' => 'desc',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Petició', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'partner',
                ModelAutocompleteType::class,
                array(
                    'property' => 'name',
                    'label' => 'Client',
                    'required' => true,
                    'callback' => function ($admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $queryBuilder = $datagrid->getQuery();
                        $queryBuilder
                            ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
                            ->setParameter('enterprise', $this->getUserLogedEnterprise())
                        ;
                        $datagrid->setValue($property, null, $value);
                    },
                )
            )
            ->add(
                'cifNif',
                TextType::class,
                array(
                    'label' => 'CIF',
                    'required' => false,
                    'mapped' => false,
                    'disabled' => true,
                )
            )
            ->add(
                'mainAddress',
                TextType::class,
                array(
                    'label' => 'Adreça principal',
                    'required' => false,
                    'mapped' => false,
                    'disabled' => true,
                )
            )
            ->add(
                'mainCity',
                TextType::class,
                array(
                    'label' => 'Població',
                    'required' => false,
                    'mapped' => false,
                    'disabled' => true,
                )
            )
            ->add(
                'province',
                TextType::class,
                array(
                    'label' => 'Província',
                    'required' => false,
                    'mapped' => false,
                    'disabled' => true,
                )
            )
            ->add(
                'paymentType',
                TextType::class,
                array(
                    'label' => 'Forma de pagament',
                    'required' => false,
                    'mapped' => false,
                    'disabled' => true,
                )
            )
            ->add(
                'contactPersonName',
                ChoiceType::class,
                array(
                    'label' => 'Persona de contacte',
//                    'choices' =>
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'contactPersonPhone',
                TextType::class,
                array(
                    'label' => 'Telèfon persona contacte',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'invoiceTo',
                ModelAutocompleteType::class,
                array(
                    'property' => 'name',
                    'label' => 'Facturar a',
                    'required' => false,
                    'callback' => function ($admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $queryBuilder = $datagrid->getQuery();
                        $queryBuilder
                            ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
                            ->setParameter('enterprise', $this->getUserLogedEnterprise())
                        ;
                        $datagrid->setValue($property, null, $value);
                    },
                )
            )
            ->add(
                'vehicle',
                EntityType::class,
                array(
                    'class' => Vehicle::class,
                    'label' => 'Vehicle',
                    'required' => true,
                    'query_builder' => $this->rm->getVehicleRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'secondaryVehicle',
                EntityType::class,
                array(
                    'class' => Vehicle::class,
                    'label' => 'Vehicle secundari',
                    'required' => false,
                    'query_builder' => $this->rm->getVehicleRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->end()
            ->with('Operador', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'operator',
                EntityType::class,
                array(
                    'class' => Operator::class,
                    'label' => 'Operador',
                    'required' => true,
                    'query_builder' => $this->rm->getOperatorRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'tariff',
                EntityType::class,
                array(
                    'class' => SaleTariff::class,
                    'label' => 'Tarifa',
                    'required' => true,
                    'query_builder' => $this->rm->getSaleTariffRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'miniumHours',
                null,
                array(
                    'label' => 'Mínim hores',
                    'required' => false,
                    'help' => '<i id="minium-hours-icon" class="fa fa-refresh fa-spin fa-fw hidden text-info"></i>',
                )
            )
            ->add(
                'hourPrice',
                null,
                array(
                    'label' => 'Preu hora',
                    'required' => false,
                    'help' => '<i id="hour-price-icon" class="fa fa-refresh fa-spin fa-fw hidden text-info"></i>',
                )
            )
            ->add(
                'displacement',
                null,
                array(
                    'label' => 'Desplaçament',
                    'required' => false,
                    'help' => '<i id="displacement-icon" class="fa fa-refresh fa-spin fa-fw hidden text-info"></i>',
                )
            )
            ->end()
            ->with('Servei', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'serviceDescription',
                null,
                array(
                    'label' => 'Descripció servei',
                    'required' => true,
                    'attr' => array(
                        'style' => 'resize: vertical',
                        'rows' => 7,
                        ),
                )
            )
            ->add(
                'height',
                null,
                array(
                    'label' => 'Alçada',
                    'required' => false,
                )
            )
            ->add(
                'distance',
                null,
                array(
                    'label' => 'Distància',
                    'required' => false,
                )
            )
            ->add(
                'weight',
                null,
                array(
                    'label' => 'Pes',
                    'required' => false,
                )
            )
            ->add(
                'place',
                null,
                array(
                    'label' => 'Lloc',
                    'required' => false,
                    'attr' => array(
                        'style' => 'resize: vertical',
                        'rows' => 3,
                    ),
                )
            )
            ->add(
                'utensils',
                null,
                array(
                    'label' => 'Utensilis',
                    'required' => false,
                )
            )
            ->add(
                'observations',
                null,
                array(
                    'label' => 'Observacions',
                    'required' => false,
                    'attr' => array(
                        'style' => 'resize: vertical',
                        'rows' => 7,
                    ),
                )
            )
            ->end()
            ->with('Data', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'requestDate',
                DatePickerType::class,
                array(
                    'label' => 'Data petició',
                    'format' => 'd/M/y',
                    'required' => false,
                    'dp_default_date' => (new \DateTime())->format('d/m/Y'),
                )
            )
            ->add(
                'serviceDate',
                DatePickerType::class,
                array(
                    'label' => 'Data servei',
                    'format' => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'serviceTime',
                TimeType::class,
                array(
                    'label' => 'Hora servei',
                    'required' => true,
                    'minutes' => array(0, 15, 30, 45),
                )
            )
            ->add(
                'endServiceTime',
                TimeType::class,
                array(
                    'label' => 'Fi hora servei',
                    'required' => false,
                    'minutes' => array(0, 15, 30, 45),
                )
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $datagridMapper
                ->add(
                    'enterprise',
                    null,
                    array(
                        'label' => 'Empresa',
                    )
                )
            ;
        }
        $datagridMapper
            ->add(
                'attendedBy',
                null,
                array(
                    'label' => 'Atès per',
                )
            )
            ->add(
                'partner',
                'doctrine_orm_model_autocomplete',
                array(
                    'label' => 'Client',
                ),
                null,
                array(
                    'property' => 'name',
                )
            )
            ->add(
                'invoiceTo',
                'doctrine_orm_model_autocomplete',
                array(
                    'label' => 'Facturar a',
                ),
                null,
                array(
                    'property' => 'name',
                )
            )
            ->add(
                'vehicle',
                null,
                array(),
                EntityType::class,
                array(
                    'class' => Vehicle::class,
                    'label' => 'Vehicle',
                    'query_builder' => $this->rm->getVehicleRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'secondaryVehicle',
                null,
                array(),
                EntityType::class,
                array(
                    'class' => Vehicle::class,
                    'label' => 'Vehicle secundari',
                    'query_builder' => $this->rm->getVehicleRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )

            ->add(
                'operator',
                null,
                array(),
                EntityType::class,
                array(
                    'class' => Operator::class,
                    'label' => 'Operador',
                    'query_builder' => $this->rm->getOperatorRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'tariff',
                null,
                array(),
                EntityType::class,
                array(
                    'class' => SaleTariff::class,
                    'label' => 'Tarifa',
                    'query_builder' => $this->rm->getSaleTariffRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'hourPrice',
                null,
                array(
                    'label' => 'Preu hora',
                )
            )
            ->add(
                'miniumHours',
                null,
                array(
                    'label' => 'Mínim hores',
                )
            )
            ->add(
                'displacement',
                null,
                array(
                    'label' => 'Desplaçament',
                )
            )
            ->add(
                'serviceDescription',
                null,
                array(
                    'label' => 'Descripció servei',
                )
            )
            ->add(
                'height',
                null,
                array(
                    'label' => 'Alçada',
                )
            )
            ->add(
                'distance',
                null,
                array(
                    'label' => 'Distància',
                )
            )
            ->add(
                'weight',
                null,
                array(
                    'label' => 'Pes',
                )
            )
            ->add(
                'place',
                null,
                array(
                    'label' => 'Lloc',
                )
            )
            ->add(
                'utensils',
                null,
                array(
                    'label' => 'Utensilis',
                )
            )
            ->add(
                'observations',
                null,
                array(
                    'label' => 'Observacions',
                )
            )
            ->add(
                'requestDate',
                'doctrine_orm_date',
                array(
                    'label' => 'Data petició',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
            ->add(
                'serviceDate',
                'doctrine_orm_date',
                array(
                    'label' => 'Data servei',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
        ;
    }

    /**
     * @param string $context
     *
     * @return QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = parent::createQuery($context);
        if (!$this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $queryBuilder
                ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
                ->setParameter('enterprise', $this->getUserLogedEnterprise())
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $listMapper
                ->add(
                    'enterprise',
                    null,
                    array(
                        'label' => 'Empresa',
                    )
                );
        }
        $listMapper
            ->add(
                'requestDate',
                null,
                array(
                    'label' => 'Data petició',
                    'format' => 'd/m/y',
                )
            )
            ->add(
                'serviceDate',
                null,
                array(
                    'label' => 'Data servei',
                    'format' => 'd/m/y',
                )
            )
            ->add(
                'serviceTime',
                null,
                array(
                    'label' => 'Hora servei',
                )
            )
            ->add(
                'vehicle',
                null,
                array(
                    'label' => 'Vehicle',
                )
            )
            ->add(
                'tariff',
                null,
                array(
                    'label' => 'Tarifa',
                )
            )
            ->add(
                'operator',
                null,
                array(
                    'label' => 'Operador',
                )
            )
            ->add(
                'partner',
                null,
                array(
                    'label' => 'Tercer',
                )
            )

            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array('template' => '::Admin/Buttons/list__action_show_button.html.twig'),
                        'edit' => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                    'label' => 'Accions',
                )
            )
        ;
    }

    /**
     * @param SaleRequest $object
     */
    public function prePersist($object)
    {
        $object->setAttendedBy($this->getUser());
        $object->setEnterprise($this->getUserLogedEnterprise());
        $object->setRequestTime(new \DateTime());

        if (null == $object->getInvoiceTo()) {
            $object->setInvoiceTo($object->getPartner());
        }
    }
}
