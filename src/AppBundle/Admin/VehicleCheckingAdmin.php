<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class VehicleCheckingAdmin
 *
 * @category Admin
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
     * Configure route collection.
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('delete');
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
                    'field_type' => 'sonata_type_date_picker',
                )
            )
            ->add(
                'end',
                'doctrine_orm_date',
                array(
                    'label' => 'Data caducitat',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
//            ->add(
//                'status',
//                null,
//                array(
//                    'label' => 'Estat',
//                    'template' => '::Admin/Cells/list__cell_vehicle_checking_status.html.twig',
//                )
//            )
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
