<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class DigitalTachographAdmin.
 *
 * @category Admin
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class DigitalTachographAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Tacògrafs';
    protected $baseRoutePattern = 'operaris/tacograf';
    protected $datagridValues = array(
        '_sort_by' => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * Configure route collection.
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('delete')
            ->add('download', $this->getRouterIdParameter().'/download')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Arxiu', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'operator',
                EntityType::class,
                array(
                    'label' => 'Operador',
                    'required' => true,
                    'class' => 'AppBundle:Operator',
                    'choice_label' => 'fullName',
                    'query_builder' => $this->rm->getOperatorRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'uploadedFile',
                FileType::class,
                array(
                    'label' => 'Arxiu tacògraf',
                    'help' => $this->getDownloadDigitalTachographButton(),
                    'required' => true,
                )
            )
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
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                'createdAt',
                'date',
                array(
                    'label' => 'Data',
                    'format' => 'd/m/Y',
                    'editable' => false,
                )
            )
            ->add(
                'profilePhotoImage',
                null,
                array(
                    'label' => 'Imatge',
                    'template' => '::Admin/Cells/list__cell_tachograph_operator_profile_image_field.html.twig',
                )
            )
            ->add(
                'operator',
                null,
                array(
                    'label' => 'Operador',
                    'editable' => false,
                    'associated_property' => 'fullName',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'surname1'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'operator')),
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'edit' => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                        'download' => array('template' => '::Admin/Buttons/list__action_download_button.html.twig'),
                    ),
                    'label' => 'Accions',
                )
            )

        ;
    }
}
