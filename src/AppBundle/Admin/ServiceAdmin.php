<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ServiceAdmin.
 */
class ServiceAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Servei';
    protected $baseRoutePattern = 'web/servei';
    protected $datagridValues = array(
        '_sort_by' => 'position',
        '_sort_order' => 'asc',
    );

    /**
     * Configure route collection.
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch');
    }

//    /**
//     * @param FormMapper $formMapper
//     */
//    protected function configureFormFields(FormMapper $formMapper)
//    {
//        $formMapper
//            ->with('backend.admin.post.post', $this->getFormMdSuccessBoxArray(6))
//            ->add(
//                'publishedAt',
//                'sonata_type_date_picker',
//                array(
//                    'label'    => 'backend.admin.published_date',
//                    'format'   => 'd/M/y',
//                    'required' => true,
//                )
//            )
//            ->add(
//                'imageFile',
//                'file',
//                array(
//                    'label'    => 'backend.admin.post.image',
//                    'help'     => $this->getImageHelperFormMapperWithThumbnail(),
//                    'required' => false,
//                )
//            )
//            ->end()
//            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(6))
//            ->add(
//                'tags',
//                null,
//                array(
//                    'label' => 'backend.admin.post.tags',
//                    'query_builder' => function (TagRepository $repository) {
//                        return $repository->getAllSortedByTitleQB();
//                    },
//                )
//            )
//            ->add(
//                'metaKeywords',
//                null,
//                array(
//                    'label' => 'backend.admin.post.metakeywords',
//                    'help'  => 'backend.admin.post.metakeywordshelp',
//                )
//            )
//            ->add(
//                'metaDescription',
//                null,
//                array(
//                    'label' => 'backend.admin.post.metadescription',
//                )
//            )
//            ->add(
//                'enabled',
//                'checkbox',
//                array(
//                    'label'    => 'backend.admin.enabled',
//                    'required' => false,
//                )
//            )
//            ->end()
//            ->with('backend.admin.post.content', $this->getFormMdSuccessBoxArray(12))
//            ->add(
//                'title',
//                null,
//                array(
//                    'label' => 'backend.admin.post.title',
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
//                    'label'       => 'backend.admin.post.description',
//                    'config_name' => 'my_config',
//                    'required'    => true,
//                )
//            )
//            ->end();
//    }
//
//    /**
//     * @param DatagridMapper $datagridMapper
//     */
//    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
//    {
//        $datagridMapper
//            ->add(
//                'publishedAt',
//                'doctrine_orm_date',
//                array(
//                    'label'      => 'backend.admin.published_date',
//                    'field_type' => 'sonata_type_date_picker',
//                )
//            )
//            ->add(
//                'title',
//                null,
//                array(
//                    'label' => 'backend.admin.post.title',
//                )
//            )
//            ->add(
//                'tags',
//                null,
//                array(
//                    'label' => 'backend.admin.post.tags',
//                )
//            )
//            ->add(
//                'description',
//                null,
//                array(
//                    'label' => 'backend.admin.post.description',
//                )
//            )
//            ->add(
//                'metaKeywords',
//                null,
//                array(
//                    'label' => 'backend.admin.post.metakeywords',
//                )
//            )
//            ->add(
//                'metaDescription',
//                null,
//                array(
//                    'label' => 'backend.admin.post.metadescription',
//                )
//            )
//            ->add(
//                'enabled',
//                null,
//                array(
//                    'label' => 'backend.admin.enabled',
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
                'mainImage',
                null,
                array(
                    'label' => 'Imatge',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig',
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
                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                    'label' => 'backend.admin.actions',
                )
            );
    }
}
