<?php

namespace AppBundle\Admin;

use AppBundle\Entity\City;
use AppBundle\Entity\Enterprise;
use AppBundle\Entity\EnterpriseTransferAccount;
use AppBundle\Entity\PartnerClass;
use AppBundle\Entity\PartnerType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Class PartnerAdmin.
 *
 * @category Admin
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class PartnerAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Tercers';
    protected $baseRoutePattern = 'tercers/tercer';
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
            ->with('General', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'cifNif',
                    null,
                    array(
                        'label' => 'CIF/NIF',
                        'required' => true,
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
                    'enterprise',
                    EntityType::class,
                    array(
                        'class' => Enterprise::class,
                        'required' => true,
                        'label' => 'Empresa',
    //                    'querybuilder' => TODO
                    )
                )
                ->add(
                    'class',
                    EntityType::class,
                    array(
                        'class' => PartnerClass::class,
                        'label' => 'Classe',
                        'required' => true,
    //                    'querybuilder' => TODO
                    )
                )
                ->add(
                    'type',
                    EntityType::class,
                    array(
                        'class' => PartnerType::class,
                        'label' => 'Tipus',
                        'required' => true,
    //                    'querybuilder' => TODO
                    )
                )
                ->add(
                    'transferAccount',
                    EntityType::class,
                    array(
                        'class' => EnterpriseTransferAccount::class,
                        'label' => 'Compte bancari empresa',
    //                    'querybuilder' => TODO
                    )
                )
                ->add(
                    'notes',
                    null,
                    array(
                        'label' => 'Notes',
                    )
                )
            ->end()
            ->with('Contacte', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'mainAddress',
                    null,
                    array(
                        'label' => 'Adreça principal',
                        'required' => true,
                    )
                )
                ->add(
                    'mainCity',
                    EntityType::class,
                    array(
                        'class' => City::class,
                        'label' => 'Ciutat principal',
                        'required' => true,
                    )
                )
                ->add(
                    'secondaryAddress',
                    null,
                    array(
                        'label' => 'Adreça secundària',
                        'required' => true,
                    )
                )
                ->add(
                    'secondaryCity',
                    EntityType::class,
                    array(
                        'class' => City::class,
                        'label' => 'Ciutat secundària',
                        'required' => true,
                    )
                )
                ->add(
                    'phoneNumber1',
                    null,
                    array(
                        'label' => 'Telèfon 1',
                    )
                )
                ->add(
                    'phoneNumber2',
                    null,
                    array(
                        'label' => 'Telèfon 2',
                    )
                )
                ->add(
                    'phoneNumber3',
                    null,
                    array(
                        'label' => 'Telèfon 3',
                    )
                )
                ->add(
                    'phoneNumber4',
                    null,
                    array(
                        'label' => 'Telèfon 4',
                    )
                )
                ->add(
                    'phoneNumber5',
                    null,
                    array(
                        'label' => 'Telèfon 5',
                    )
                )
                ->add(
                    'faxNumber1',
                    null,
                    array(
                        'label' => 'Fax 1',
                    )
                )
                ->add(
                    'faxNumber2',
                    null,
                    array(
                        'label' => 'Fax 2',
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
                        'label' => 'Pàgina web',
                    )
                )
            ->end()
            ->with('Controls', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'discount',
                    null,
                    array(
                        'label' => 'Descompte',
                    )
                )
                ->add(
                    'code',
                    null,
                    array(
                        'label' => 'Codi',
                    )
                )
                ->add(
                    'providerReference',
                    null,
                    array(
                        'label' => 'Referència proveïdor',
                    )
                )
                ->add(
                    'reference',
                    null,
                    array(
                        'label' => 'Referència',
                    )
                )
                ->add(
                    'ivaTaxFree',
                    null,
                    array(
                        'label' => 'Exent IVA',
                    )
                )
                ->add(
                    'iban',
                    null,
                    array(
                        'label' => 'IBAN',
                    )
                )
                ->add(
                    'swift',
                    null,
                    array(
                        'label' => 'SWIFT',
                    )
                )
                ->add(
                    'bankCode',
                    null,
                    array(
                        'label' => 'Codi bancari',
                    )
                )
                ->add(
                    'officeNumber',
                    null,
                    array(
                        'label' => 'Número oficina',
                    )
                )
                ->add(
                    'controlDigit',
                    null,
                    array(
                        'label' => 'Dígit control',
                    )
                )
                ->add(
                    'accountNumber',
                    null,
                    array(
                        'label' => 'Número compte',
                    )
                )
                ->add(
                    'enabled',
                    CheckboxType::class,
                    array(
                        'label' => 'Actiu',
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
                'cifNif',
                null,
                array(
                    'label' => 'CIF/NIF',
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
                'class',
                null,
                array(
                    'label' => 'Classe',
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus',
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
                'cifNif',
                null,
                array(
                    'label' => 'CIF/NIF',
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
                'class',
                null,
                array(
                    'label' => 'Classe',
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus',
                )
            )
            ->add(
                'phoneNumber1',
                null,
                array(
                    'label' => 'Telèfon 1',
                    'editable' => true,
                )
            )
            ->add(
                'Email',
                null,
                array(
                    'label' => 'Email',
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
                    'label' => 'Accions',
                )
            )
        ;
    }
}