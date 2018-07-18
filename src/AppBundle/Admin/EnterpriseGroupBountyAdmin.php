<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class EnterpriseGroupBountyAdmin.
 *
 * @category    Admin
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class EnterpriseGroupBountyAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Primes';
    protected $baseRoutePattern = 'empreses/grup-primes';
    protected $datagridValues = array(
        '_sort_by' => 'group',
        '_sort_order' => 'asc',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

//enterprise* : Enterprise
//group* : string

//normalHour : float
//extraNormalHour : float
//extraExtraHour : float
//roadNormalHour : float
//roadExtraHour : float
//awaitingHour : float
//negativeHour : float
//transferHour : float

//lunch : float
//dinner : float
//overnight : float
//extraNight : float
//diet : float
//internationalLunch : float
//internationalDinner : float
//truckOutput : float
//carOutput : float
        ->with('Grup', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'enterprise',
                EntityType::class,
                array(
                    'label' => 'Empresa',
                    'required' => true,
                    'class' => 'AppBundle:Enterprise',
                )
            )

            ->add(
                'group',
                null,
                array(
                    'label' => 'Grup',
                    'required' => true,
                )
            )
        ->end()
        ->with('Hores', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'normalHour',
                null,
                array(
                    'label' => 'Normal',
                    'required' => true,
                )
            )
            ->add(
                'extraNormalHour',
                null,
                array(
                    'label' => 'Extra normal',
                    'required' => true,
                )
            )
            ->add(
                'extraExtraHour',
                null,
                array(
                    'label' => 'Extra extra',
                    'required' => true,
                )
            )
            ->add(
                'roadNormalHour',
                null,
                array(
                    'label' => 'Ctra. normal',
                    'required' => true,
                )
            )
            ->add(
                'roadExtraHour',
                null,
                array(
                    'label' => 'Ctra. extra',
                    'required' => true,
                )
            )
            ->add(
                'awaitingHour',
                null,
                array(
                    'label' => 'Espera',
                    'required' => true,
                )
            )
            ->add(
                'negativeHour',
                null,
                array(
                    'label' => 'Negativa',
                    'required' => true,
                )
            )
            ->add(
                'transferHour',
                null,
                array(
                    'label' => 'Transbordament',
                    'required' => true,
                )
            )
            ->end()
        ->with('Dietes i trucades', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'lunch',
                null,
                array(
                    'label' => 'Dinar',
                    'required' => true,
                )
            )
            ->add(
                'dinner',
                null,
                array(
                    'label' => 'Sopar',
                    'required' => true,
                )
            )
            ->add(
                'overNight',
                null,
                array(
                    'label' => 'Pernocta',
                    'required' => true,
                )
            )
//            ->add(
//                'extraNight',
//                null,
//                array(
//                    'label' => 'Nit extra',
//                    'required' => true,
//                )
//            )
            ->add(
                'diet',
                null,
                array(
                    'label' => 'Dieta',
                    'required' => true,
                )
            )
            ->add(
                'internationalLunch',
                null,
                array(
                    'label' => 'Dinar int.',
                    'required' => true,
                )
            )
            ->add(
                'internationalDinner',
                null,
                array(
                    'label' => 'Sopar int.',
                    'required' => true,
                )
            )
            ->add(
                'truckOutput',
                null,
                array(
                    'label' => 'Sortida camió',
                    'required' => true,
                )
            )
            ->add(
                'carOutput',
                null,
                array(
                    'label' => 'Sortida cotxe',
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
                'enterprise',
                null,
                array(
                    'label' => 'Empresa',
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
                'enterprise',
                null,
                array(
                    'label' => 'Empresa',
                    'editable' => false,
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
