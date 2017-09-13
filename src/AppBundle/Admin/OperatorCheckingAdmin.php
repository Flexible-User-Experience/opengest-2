<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class OperatorCheckingAdmin.
 *
 * @category Admin
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class OperatorCheckingAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Revisions';
    protected $baseRoutePattern = 'administracio/operador/revisio';
    protected $datagridValues = array(
        '_sort_by' => 'name',
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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'operator',
                EntityType::class,
                array(
                    'label' => 'Operador',
                    'required' => true,
                    'class' => 'AppBundle:Operator',
                    'choice_label' => 'fullName',
                    'query_builder' => $this->rm->getOperatorRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->ts->getToken()->getUser()->getDefaultEnterprise()),
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisió',
                    'required' => true,
                )
            )
            ->add(
                'begin',
                'sonata_type_date_picker',
                array(
                    'label' => 'Data d\'expedició',
                    'format' => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'end',
                'sonata_type_date_picker',
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
                'operator',
                null,
                array(
                    'label' => 'Operador',
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisó',
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
            ->add(
                'operator',
                null,
                array(
                    'label' => 'Operador',
                    'editable' => true,
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisió',
                    'editable' => false,
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
//                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                    'label' => 'Accions',
                )
            )
        ;
    }
}
