<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class EnterpriseAdmin.
 *
 * @category    Admin
 * @auhtor      Wils Iglesias <wiglesias83@gmail.com>
 */
class EnterpriseAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Empresa';
    protected $baseRoutePattern = 'administracio/empresa';
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
            ->tab('Informació')
                ->with('General', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'logoFile',
                        FileType::class,
                        array(
                            'label' => 'Logo',
                            'help' => $this->getLogoHelperFormMapperWithThumbnail(),
                            'required' => false,
                        )
                    )
                    ->add(
                        'taxIdentificationNumber',
                        null,
                        array(
                            'label' => 'CIF',
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
                        'businessName',
                        null,
                        array(
                            'label' => 'Nom fiscal',
                        )
                    )
                ->end()
                ->with('Contacte', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'address',
                        null,
                        array(
                            'label' => 'Adreça',
                        )
                    )
                    ->add(
                        'city',
                        null,
                        array(
                            'label' => 'Ciutat',
                            'required' => true,
                        )
                    )
                    ->add(
                        'email',
                        null,
                        array(
                            'label' => 'Email',
                        )
                    )
                    ->add(
                        'www',
                        null,
                        array(
                            'label' => 'Web corporativa',
                        )
                    )
                    ->add(
                        'phone1',
                        null,
                        array(
                            'label' => 'Telèfon 1',
                        )
                    )
                    ->add(
                        'phone2',
                        null,
                        array(
                            'label' => 'Telèfon 2',
                        )
                    )
                    ->add(
                        'phone3',
                        null,
                        array(
                            'label' => 'Telèfon 3',
                        )
                    )
                ->end()
                ->with('Controls', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'enabled',
                        CheckboxType::class,
                        array(
                            'label' => 'Actiu',
                            'required' => false,
                        )
                    )
                ->end()
            ->end()
            ->tab('Recursos')
                ->with('TC\'s', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'tc1ReceiptFile',
                        FileType::class,
                        array(
                            'label' => 'Rebut TC1',
                            'help' => $this->getSmartHelper('getTc1Receipt', 'tc1ReceiptFile'),
                            'required' => false,
                        )
                    )
                    ->add(
                        'tc2ReceiptFile',
                        FileType::class,
                        array(
                            'label' => 'Rebut TC2',
                            'help' => $this->getSmartHelper('getTc2Receipt', 'tc2ReceiptFile'),
                            'required' => false,
                        )
                    )
                ->end()
//                ->with('Documents', $this->getFormMdSuccessBoxArray(6))
//                ->end()
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
                'taxIdentificationNumber',
                null,
                array(
                    'label' => 'CIF',
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
                'email',
                null,
                array(
                    'label' => 'Email',
                )
            )
            ->add(
                'city',
                null,
                array(
                    'label' => 'Ciutat',
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
                'logo',
                null,
                array(
                    'label' => 'Logo',
                    'template' => '::Admin/Cells/list__cell_logo_image_field.html.twig',
                )
            )
            ->add(
                'taxIdentificationNumber',
                null,
                array(
                    'label' => 'CIF',
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
                'email',
                null,
                array(
                    'label' => 'Email',
                    'editable' => true,
                )
            )
            ->add(
                'city',
                null,
                array(
                    'label' => 'Ciutat',
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
            )
        ;
    }
}
