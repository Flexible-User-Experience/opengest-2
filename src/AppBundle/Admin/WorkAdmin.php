<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class WorkAdmin.
 *
 * @category Admin
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class WorkAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Treball';
    protected $baseRoutePattern = 'web/treball';
    protected $datagridValues = array(
        '_sort_by' => 'date',
        '_sort_order' => 'desc',
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
                'name',
                null,
                array(
                    'label' => 'Nom',
                )
            )
            ->add(
                'shortDescription',
                null,
                array(
                    'label' => 'Descripció breu',
                )
            )
            ->add(
                'description',
                CKEditorType::class,
                array(
                    'label' => 'Descripció',
                    'config_name' => 'my_config',
                    'required' => true,
                )
            )
            ->add(
                'mainImageFile',
                FileType::class,
                array(
                    'label' => 'Imatge',
                    'help' => $this->getMainImageHelperFormMapperWithThumbnail(),
                    'required' => false,
                )
            )
            ->end()
            ->with('Controls', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'date',
                DatePickerType::class,
                array(
                    'label' => 'Data',
                    'format' => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'service',
                null,
                array(
                    'label' => 'Servei',
                    'required' => false,
                    'query_builder' => $this->rm->getServiceRepository()->findEnabledSortedByNameQB(),
                )
            )
            ->add(
                'enabled',
                CheckboxType::class,
                array(
                    'label' => 'Actiu',
                    'required' => false,
                )
            )
            ->end()
        ;
        if ($this->id($this->getSubject())) { // is edit mode, disable on new subjetcs
            $formMapper
                ->with('Imatges', $this->getFormMdSuccessBoxArray(12))
                ->add(
                    'images',
                    CollectionType::class,
                    array(
                        'label' => 'Imatges',
                        'required' => true,
                        'cascade_validation' => true,
                        'error_bubbling' => true,
                        'by_reference' => false,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    )
                )
                ->end()
            ;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'date',
                'doctrine_orm_date',
                array(
                    'label' => 'Data',
                    'field_type' => DatePickerType::class,
                )
            )
            ->add(
                'service',
                null,
                array(
                    'label' => 'Servei',
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'Nom',
                )
            )
            ->add(
                'shortDescription',
                null,
                array(
                    'label' => 'Descripció breu',
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label' => 'Descripció',
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'Actiu',
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
                'mainImage',
                null,
                array(
                    'label' => 'Imatge',
                    'template' => '::Admin/Cells/list__cell_main_image_field.html.twig',
                )
            )
            ->add(
                'date',
                'date',
                array(
                    'label' => 'Data',
                    'format' => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'Nom',
                    'editable' => true,
                )
            )
            ->add(
                'shortDescription',
                null,
                array(
                    'label' => 'Descripció breu',
                    'editable' => true,
                )
            )
            ->add(
                'service',
                null,
                array(
                    'label' => 'Servei',
                    'editable' => false,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'service')),                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'Actiu',
                    'editable' => true,
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
