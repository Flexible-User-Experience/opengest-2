<?php

namespace AppBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class VehicleAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Vehicle';
    protected $baseRoutePattern = 'web/vehicle';
    protected $datagridValues = array(
        '_sort_by' => 'name',
        '_sort_order' => 'asc',
    );

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
            ->add(
                'attatchmentPDFFile',
                'file',
                array(
                    'label' => 'Document',
                    'required' => false,
                )
            )
            ->end()
            ->with('Controls', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'link',
                null,
                array(
                    'label' => 'Url',
                    'required' => false,
  //                  'query_builder' => $this->rm->getServiceRepository()->findEnabledSortedByNameQB(),
                )
            )
            ->add(
                'category',
                null,
                array(
                    'label' => 'Category',
                    'required' => true,
  //                  'query_builder' => $this->rm->getServiceRepository()->findEnabledSortedByNameQB(),
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
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'name',
                null,
                array(
                    'label' => 'Nom',
                )
            )
            ->add(
                'category',
                null,
                array(
                    'label' => 'Categoria',
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
                'link',
                null,
                array(
                    'label' => 'Url',
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'Actiu',
                )
            );
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
                'category',
                null,
                array(
                    'label' => 'Categoria',
                    'editable' => false,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'category')),                )
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
//                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                    'label' => 'Accions',
                )
            );
    }
}
