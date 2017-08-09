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
//                    ->add(
//                        'email',
//                        null,
//                        array(
//                            'label' => 'Email',
//                        )
//                    )
//                    ->add(
//                        'www',
//                        null,
//                        array(
//                            'label' => 'Web corporativa',
//                        )
//                    )
//                    ->add(
//                        'phone1',
//                        null,
//                        array(
//                            'label' => 'Telèfon 1',
//                        )
//                    )
//                    ->add(
//                        'phone2',
//                        null,
//                        array(
//                            'label' => 'Telèfon 2',
//                        )
//                    )
//                    ->add(
//                        'phone3',
//                        null,
//                        array(
//                            'label' => 'Telèfon 3',
//                        )
//                    )
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
//                ->end()
//            ->tab('Recursos')
//                ->with('TC\'s', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'tc1ReceiptFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut TC1',
//                        'help' => $this->getSmartHelper('getTc1Receipt', 'tc1ReceiptFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'tc2ReceiptFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut TC2',
//                        'help' => $this->getSmartHelper('getTc2Receipt', 'tc2ReceiptFile'),
//                        'required' => false,
//                    )
//                )
//                ->end()
//                ->with('Seguretat Social', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'ssRegistrationFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut SS registre',
//                        'help' => $this->getSmartHelper('getSsRegistration', 'ssRegistrationFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'ssPaymentCertificateFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut pagament certificat',
//                        'help' => $this->getSmartHelper('getSsPaymentCertificate', 'ssPaymentCertificateFile'),
//                        'required' => false,
//                    )
//                )
//                ->end()
//                ->with('Responsabilitat Civil', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'rc1InsuranceFile',
//                    FileType::class,
//                    array(
//                        'label' => 'RC 1',
//                        'help' => $this->getSmartHelper('getRc1Insurance', 'rc1InsuranceFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'rc2InsuranceFile',
//                    FileType::class,
//                    array(
//                        'label' => 'RC 2',
//                        'help' => $this->getSmartHelper('getRc2Insurance', 'rc2InsuranceFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'rcReceiptFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut RC',
//                        'help' => $this->getSmartHelper('getRcReceipt', 'rcReceiptFile'),
//                        'required' => false,
//                    )
//                )
//                ->end()
//                ->with('Riscos Laborals', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'preventionServiceContractFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Contracte',
//                        'help' => $this->getSmartHelper('getPreventionServiceContract', 'preventionServiceContractFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'preventionServiceInvoiceFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Factura',
//                        'help' => $this->getSmartHelper('getPreventionServiceInvoice', 'preventionServiceInvoiceFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'preventionServiceReceiptFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut',
//                        'help' => $this->getSmartHelper('getPreventionServiceReceipt', 'preventionServiceReceiptFile'),
//                        'required' => false,
//                    )
//                )
//                ->end()
//                ->with('Assegurances', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'occupationalAccidentsInsuranceFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Assegurança d\'accident de treball',
//                        'help' => $this->getSmartHelper('getOccupationalAccidentsInsurance', 'occupationalAccidentsInsuranceFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'occupationalReceiptFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut',
//                        'help' => $this->getSmartHelper('getOccupationalReceipt', 'occupationalReceiptFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'laborRiskAssessmentFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Avaluació riscos',
//                        'help' => $this->getSmartHelper('getLaborRiskAssessment', 'laborRiskAssessmentFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'securityPlanFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Pla seguretat',
//                        'help' => $this->getSmartHelper('getSecurityPlan', 'securityPlanFile'),
//                        'required' => false,
//                    )
//                )
//                ->end()
//                ->with('Impost d\'Activitats Econòmiques', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'iaeRegistrationFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Alta IAE',
//                        'help' => $this->getSmartHelper('getIaeRegistration', 'iaeRegistrationFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'iaeReceiptFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Rebut IAE',
//                        'help' => $this->getSmartHelper('getIaeReceipt', 'iaeReceiptFile'),
//                        'required' => false,
//                    )
//                )
//                ->end()
//                ->with('Altres Documents', $this->getFormMdSuccessBoxArray(3))
//                ->add(
//                    'reaCertificateFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Certificat REA',
//                        'help' => $this->getSmartHelper('getReaCertificate', 'reaCertificateFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'oilCertificateFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Certificat recullida d\'oli',
//                        'help' => $this->getSmartHelper('getOilCertificate', 'oilCertificateFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'gencatPaymentCertificateFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Certificat pagament Generalitat',
//                        'help' => $this->getSmartHelper('getGencatPaymentCertificate', 'gencatPaymentCertificateFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'deedsOfPowersFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Escriptura de poder',
//                        'help' => $this->getSmartHelper('getDeedsOfPowers', 'deedsOfPowersFile'),
//                        'required' => false,
//                    )
//                )
//                ->add(
//                    'mutualPartnershipFile',
//                    FileType::class,
//                    array(
//                        'label' => 'Document associació a mutua',
//                        'help' => $this->getSmartHelper('getMutualPartnership', 'mutualPartnershipFile'),
//                        'required' => false,
//                    )
//                )
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
