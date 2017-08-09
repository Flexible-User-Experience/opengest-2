<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class OperatorAdmin.
 *
 * @author Wils Iglesias <wiglesias83@gmail.com>
 */
class OperatorAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Operadors';
    protected $baseRoutePattern = 'administracio/operador';
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
                        'profilePhotoImageFile',
                        FileType::class,
                        array(
                            'label' => 'Imatge',
                            'help' => $this->getProfileHelperFormMapperWithThumbnail(),
                            'required' => false,
                        )
                    )
                    ->add(
                        'taxIdentificationNumber',
                        null,
                        array(
                            'label' => 'DNI/NIE',
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
                        'surname1',
                        null,
                        array(
                            'label' => 'Primer cognom',
                        )
                    )
                    ->add(
                        'surname2',
                        null,
                        array(
                            'label' => 'Segon cognom',
                        )
                    )
                ->end()
                ->with('Contacte', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'address',
                        null,
                        array(
                            'label' => 'Adreça',
                            'required' => false,
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
                        'enterpriseMobile',
                        null,
                        array(
                            'label' => 'Mòbil d\'empresa',
                            'required' => true,
                        )
                    )
                    ->add(
                        'ownPhone',
                        null,
                        array(
                            'label' => 'Telèfon personal',
                            'required' => true,
                        )
                    )
                    ->add(
                        'ownMobile',
                        null,
                        array(
                            'label' => 'Mòbil personal',
                            'required' => true,
                        )
                    )
                ->end()
                ->with('Controls', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'brithDate',
                        'sonata_type_date_picker',
                        array(
                            'label' => 'Data de naixement',
                            'format' => 'd/M/y',
                            'required' => true,
                        )
                    )
                    ->add(
                        'registrationDate',
                        'sonata_type_date_picker',
                        array(
                            'label' => 'Data de registre',
                            'format' => 'd/M/y',
                            'required' => true,
                        )
                    )
                    ->add(
                        'bancAccountNumber',
                        null,
                        array(
                            'label' => 'No. de compte bancari',
                            'required' => true,
                        )
                    )
                    ->add(
                        'socialSecurityNumber',
                        null,
                        array(
                            'label' => 'No. de Seguretat Social',
                            'required' => true,
                        )
                    )
                    ->add(
                        'hourCost',
                        null,
                        array(
                            'label' => 'Cost hora',
                            'required' => true,
                        )
                    )
                    ->add(
                        'hasCarDrivingLicense',
                        CheckboxType::class,
                        array(
                            'label' => 'Llicència conducció de cotxe',
                            'required' => true,
                        )
                    )
                    ->add(
                        'hasLorryDrivingLicense',
                        CheckboxType::class,
                        array(
                            'label' => 'Llicència conducció de camions',
                            'required' => true,
                        )
                    )
                    ->add(
                        'hasTowingDrivingLicense',
                        CheckboxType::class,
                        array(
                            'label' => 'Llicència conducció de remolc',
                            'required' => false,
                        )
                    )
                    ->add(
                        'hasCraneDrivingLicense',
                        CheckboxType::class,
                        array(
                            'label' => 'Llicència conducció de grua',
                            'required' => false,
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
                ->with('EPI\'s', $this->getFormMdSuccessBoxArray(4))
                    ->add(
                        'shoeSize',
                        null,
                        array(
                            'label' => 'Mida de sabata',
                            'required' => false,
                        )
                    )
                    ->add(
                        'jerseytSize',
                        null,
                        array(
                            'label' => 'Mida de jersei',
                            'required' => false,
                        )
                    )
                    ->add(
                        'jacketSize',
                        null,
                        array(
                            'label' => 'Mida de jaqueta',
                            'required' => false,
                        )
                    )
                    ->add(
                        'tShirtSize',
                        null,
                        array(
                            'label' => 'Mida de camisa',
                            'required' => false,
                        )
                    )
                    ->add(
                        'pantSize',
                        null,
                        array(
                            'label' => 'Mida de pantaló',
                            'required' => false,
                        )
                    )
                    ->add(
                        'workingDressSize',
                        null,
                        array(
                            'label' => 'Mida de roba de treball',
                            'required' => false,
                        )
                    )
                ->end()
            ->end()
            ->tab('Recursos')
                ->with('No. d\'identificació fiscal', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'taxIdentificationNumberImageFile',
                        FileType::class,
                        array(
                            'label' => 'DNI/NIE',
                            'help' => $this->getSmartHelper('getTaxIdentificationNumberImage', 'taxIdentificationNumberImageFile'),
                            'required' => false,
                        )
                    )
                    ->end()
                ->with('Seguretat Social', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'dischargeSocialSecurityImageFile',
                        FileType::class,
                        array(
                            'label' => 'Baixa Seguretat Social',
                            'help' => $this->getSmartHelper('getDischargeSocialSecurityImage', 'dischargeSocialSecurityImageFile'),
                            'required' => false,
                        )
                    )
                ->end()
                ->with('Contracte de treball', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'employmentContractImageFile',
                        FileType::class,
                        array(
                            'label' => 'Contracte',
                            'help' => $this->getSmartHelper('getEmploymentContractImage', 'employmentContractImageFile'),
                            'required' => false,
                        )
                    )
                    ->end()
                ->with('Informe mèdic', $this->getFormMdSuccessBoxArray(3))
                ->add(
                    'medicalCheckImageFile',
                    FileType::class,
                    array(
                        'label' => 'Revisió mèdica',
                        'help' => $this->getSmartHelper('getMedicalCheckImage', 'medicalCheckImageFile'),
                        'required' => false,
                    )
                )
                ->end()
                ->with('EPI\'s', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'episImageFile',
                        FileType::class,
                        array(
                            'label' => 'EPI',
                            'help' => $this->getSmartHelper('getEpisImage', 'episImageFile'),
                            'required' => false,
                        )
                    )
                ->end()
                ->with('Formació', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'trainingDocumentImageFile',
                        FileType::class,
                        array(
                            'label' => 'Títol de formació',
                            'help' => $this->getSmartHelper('getTrainingDocumentImage', 'trainingDocumentImageFile'),
                            'required' => false,
                        )
                    )
                ->end()
                ->with('Altres Documents', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'informationImageFile',
                        FileType::class,
                        array(
                            'label' => 'Altra informació',
                            'help' => $this->getSmartHelper('getInformationImage', 'informationImageFile'),
                            'required' => false,
                        )
                    )
                ->end()
                ->with('Llicències', $this->getFormMdSuccessBoxArray(3))
                    ->add(
                        'drivingLicenseImageFile',
                        FileType::class,
                        array(
                            'label' => 'Carnet de conduir',
                            'help' => $this->getSmartHelper('getDrivingLicenseImage', 'drivingLicenseImageFile'),
                            'required' => false,
                        )
                    )
                    ->add(
                        'useOfMachineryAuthorizationImageFile',
                        FileType::class,
                        array(
                            'label' => 'Autorització de maquinària',
                            'help' => $this->getSmartHelper('getUseOfMachineryAuthorizationImage', 'useOfMachineryAuthorizationImageFile'),
                            'required' => false,
                        )
                    )
                    ->add(
                        'cranesOperatorLicenseImageFile',
                        FileType::class,
                        array(
                            'label' => 'Llicència d\'operador',
                            'help' => $this->getSmartHelper('getCranesOperatorLicenseImage', 'cranesOperatorLicenseImageFile'),
                            'required' => false,
                        )
                    )
                ->end()
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
                    'label' => 'DNI/NIE',
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
                'surname1',
                null,
                array(
                    'label' => 'Primer cognom',
                )
            )
            ->add(
                'enterprise',
                null,
                array(
                    'label' => 'Empresa',
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
                'profilePhotoImage',
                null,
                array(
                    'label' => 'Imatge',
                    'template' => '::Admin/Cells/list__cell_profile_image_field.html.twig',
                )
            )
            ->add(
                'taxIdentificationNumber',
                null,
                array(
                    'label' => 'DNI/NIE',
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
                'surname1',
                null,
                array(
                    'label' => 'Primer cognom',
                    'editable' => true,
                )
            )
            ->add(
                'surname2',
                null,
                array(
                    'label' => 'Segon cognom',
                    'editable' => true,
                )
            )
            ->add(
                'enterprise',
                null,
                array(
                    'label' => 'Empresa',
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