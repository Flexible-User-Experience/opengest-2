<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\Operator;
use AppBundle\Entity\Partner;
use AppBundle\Entity\SaleTariff;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

        ->with('General', $this->getFormMdSuccessBoxArray(12))
            ->add(
                'enterprise',
                EntityType::class,
                array(
                    'class' => Enterprise::class,
                    'label' => false,
                    'required' => true,
                    'query_builder' => $this->rm->getEnterpriseRepository()->getEnterprisesByUserQB($this->getUser()),
                    'attr' => array(
                        'style' => 'display:none;',
                    ),
                )
            )
            ->add(
                'attendedBy',
                EntityType::class,
                array(
                    'class' => User::class,
                    'label' => false,
                    'required' => true,
                    'query_builder' => $this->getUser(),
                    'attr' => array(
                        'style' => 'display:none;',
                    ),
                )
            )
        ->end()
        ->with('Tercer', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'partner',
                EntityType::class,
                array(
                    'class' => Partner::class,
                    'label' => 'Tercer',
                    'required' => true,
                )
            )
            ->add(
                'invoiceTo',
                EntityType::class,
                array(
                    'class' => Partner::class,
                    'label' => 'Facturar a',
                    'required' => true,
                )
            )
            ->add(
                'vehicle',
                EntityType::class,
                array(
                    'class' => Vehicle::class,
                    'label' => 'Vehicle',
                    'required' => true,
                )
            )
            ->add(
                'secondaryVehicle',
                EntityType::class,
                array(
                    'class' => Vehicle::class,
                    'label' => 'Vehicle secundari',
                    'required' => false,
                )
            )
        ->end()

        ->with('Operador', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'operator',
                EntityType::class,
                array(
                    'class' => Operator::class,
                    'label' => 'Operador',
                    'required' => true,
                )
            )
            ->add(
                'tarill',
                EntityType::class,
                array(
                    'class' => SaleTariff::class,
                    'label' => 'Tarifa',
                    'required' => true,
                )
            )
            ->add(
                'hourPrice',
                null,
                array(
                    'label' => 'Preu hora',
                    'required' => false,
                )
            )
            ->add(
                'miniumHours',
                null,
                array(
                    'label' => 'Mínim hores',
                    'required' => false,
                )
            )
            ->add(
                'displacement',
                null,
                array(
                    'label' => 'Desplaçament',
                    'required' => false,
                )
            )
        ->end()

        ->with('Servei', $this->getFormMdSuccessBoxArray(4))
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
                    'label' => 'Distancia',
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
                    'required' => true,
                    'attr' => array(
                        'style' => 'resize: vertical',
                        'rows' => 7,
                    ),
                )
            )
        ->end()

        ->with('Data', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'requestDate',
                'doctrine_orm_date',
                array(
                    'label' => 'Data petició',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
            ->add(
                'requestTime',
                'doctrine_orm_date',
                array(
                    'label' => 'Hora petició',
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
            ->add(
                'serviceTime',
                'doctrine_orm_date',
                array(
                    'label' => 'Hora servei',
                    'field_type' => 'sonata_type_date_picker',
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
        $datagridMapper
            ->add(
                'requestTime',
                'doctrine_orm_date',
                array(
                    'label' => 'Data petició',
                    'field_type' => 'sonata_type_date_picker',
                )
            )

        ;
    }

//    /**
//     * @param string $context
//     *
//     * @return QueryBuilder
//     */
//    public function createQuery($context = 'list')
//    {
//        /** @var QueryBuilder $queryBuilder */
//        $queryBuilder = parent::createQuery($context);
//        if (!$this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
//            $queryBuilder
//                ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
//                ->setParameter('enterprise', $this->getUserLogedEnterprise())
//            ;
//        }
//
//        return $queryBuilder;
//    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            //        requestDate, serviceDate, serviceHour, vehicle, tariff, operator i partner
            ->add(
                'requestTime',
                null,
                array(
                    'label' => 'Data petició',
                )
            )
            ->add(
                'servideDate',
                null,
                array(
                    'label' => 'Data servei',
                )
            )
            ->add(
                'serviceHour',
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
}
