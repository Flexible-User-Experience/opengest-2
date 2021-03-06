<?php

namespace AppBundle\Admin\Vehicle;

use AppBundle\Admin\AbstractBaseAdmin;
use AppBundle\Entity\Vehicle\Vehicle;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class VehicleCheckingAdmin.
 *
 * @category Admin
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleCheckingAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Revisions';
    protected $baseRoutePattern = 'vehicles/revisio';
    protected $datagridValues = array(
        '_sort_by' => 'end',
        '_sort_order' => 'asc',
    );

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('delete');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'vehicle',
                EntityType::class,
                array(
                    'label' => 'Vehicle',
                    'required' => true,
                    'class' => Vehicle::class,
                    'choice_label' => 'name',
                    'query_builder' => $this->rm->getVehicleRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisió',
                    'required' => true,
                    'query_builder' => $this->rm->getVehicleCheckingTypeRepository()->getEnabledSortedByNameQB(),
                )
            )
            ->add(
                'begin',
                DatePickerType::class,
                array(
                    'label' => 'Data d\'expedició',
                    'format' => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'end',
                DatePickerType::class,
                array(
                    'label' => 'Data de caducitat',
                    'format' => 'd/M/y',
                    'required' => true,
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
                'vehicle',
                null,
                array(
                    'label' => 'Vehicle',
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisó',
                )
            )
            ->add(
                'begin',
                'doctrine_orm_date',
                array(
                    'label' => 'Data d\'expedició',
                    'field_type' => DatePickerType::class,
                )
            )
            ->add(
                'end',
                'doctrine_orm_date',
                array(
                    'label' => 'Data caducitat',
                    'field_type' => DatePickerType::class,
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
        $queryBuilder
            ->join($queryBuilder->getRootAliases()[0].'.vehicle', 'v')
            ->andWhere('v.enabled = :enabled')
            ->setParameter('enabled', true)
        ;
        if (!$this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $queryBuilder
                ->andWhere('v.enterprise = :enterprise')
                ->setParameter('enterprise', $this->ts->getToken()->getUser()->getDefaultEnterprise())
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
        $listMapper
            ->add(
                'status',
                null,
                array(
                    'label' => 'Estat',
                    'template' => '::Admin/Cells/list__cell_vehicle_checking_status.html.twig',
                )
            )
            ->add(
                'begin',
                'date',
                array(
                    'label' => 'Data d\'expedició',
                    'format' => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'end',
                'date',
                array(
                    'label' => 'Data caducitat',
                    'format' => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'vehicle',
                null,
                array(
                    'label' => 'Vehicle',
                    'editable' => false,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'vehicle')),
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisió',
                    'editable' => true,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'type')),
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array('template' => '::Admin/Buttons/list__action_show_button.html.twig'),
                        'edit' => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                    ),
                    'label' => 'Accions',
                )
            )
        ;
    }
}
