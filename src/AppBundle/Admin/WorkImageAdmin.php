<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class WorkImageAdmin.
 *
 * @category Admin
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class WorkImageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Imatge Treball';
    protected $baseRoutePattern = 'web/imatge-treball';
    protected $datagridValues = array(
        '_sort_by' => 'position',
        '_sort_order' => 'asc',
    );

//    /**
//     * @param FormMapper $formMapper
//     */
//    protected function configureFormFields(FormMapper $formMapper)
//    {
//        $formMapper
//            ->with('Servei', $this->getFormMdSuccessBoxArray(6))
//            ->add(
//                'date',
//                'sonata_type_date_picker',
//                array(
//                    'label' => 'Data',
//                    'format' => 'd/M/y',
//                    'required' => true,
//                )
//            )
//            ->add(
//                'name',
//                null,
//                array(
//                    'label' => 'Nom',
//                )
//            )
//            ->add(
//                'shortDescription',
//                null,
//                array(
//                    'label' => 'backend.admin.post.shortdescription',
//                )
//            )
//            ->add(
//                'description',
//                CKEditorType::class,
//                array(
//                    'label' => 'Descripció',
//                    'config_name' => 'my_config',
//                    'required' => true,
//                )
//            )
//            ->add(
//                'mainImageFile',
//                FileType::class,
//                array(
//                    'label' => 'Imatge',
//                    'help' => $this->getImageHelperFormMapperWithThumbnail(),
//                    'required' => false,
//                )
//            )
//            ->end()
//            ->with('Controls', $this->getFormMdSuccessBoxArray(6))
//            ->add(
//                'enabled',
//                CheckboxType::class,
//                array(
//                    'label' => 'Actiu',
//                    'required' => false,
//                )
//            )
//            ->end();
//    }

//    /**
//     * @param DatagridMapper $datagridMapper
//     */
//    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
//    {
//        $datagridMapper
//            ->add(
//                'date',
//                'doctrine_orm_date',
//                array(
//                    'label' => 'Data',
//                    'field_type' => 'sonata_type_date_picker',
//                )
//            )
//            ->add(
//                'name',
//                null,
//                array(
//                    'label' => 'Nom',
//                )
//            )
//            ->add(
//                'description',
//                null,
//                array(
//                    'label' => 'Descripció',
//                )
//            )
//            ->add(
//                'enabled',
//                null,
//                array(
//                    'label' => 'Actiu',
//                )
//            );
//    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'image',
                null,
                array(
                    'label' => 'Imatge',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig',
                )
            )
            ->add(
                'alt',
                null,
                array(
                    'label' => 'Alt',
                    'editable' => true,
                )
            )
            ->add(
                'position',
                null,
                array(
                    'label' => 'Posició',
                    'editable' => true,
                )
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
