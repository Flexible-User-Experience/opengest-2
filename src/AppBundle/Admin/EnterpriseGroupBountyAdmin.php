<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Enterprise;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
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
    protected $classnameLabel = 'Prima';
    protected $baseRoutePattern = 'empreses/grup-prima';
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

        ->with('Grup', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'enterprise',
                EntityType::class,
                array(
                    'class' => Enterprise::class,
                    'label' => false,
                    'required' => true,
                    'query_builder' => $this->rm->getEnterpriseRepository()->getEnterprisesByUserQB($this->getUser()),
                    'attr' => array(
                        'style' => 'display:none;',
                    ),
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
                    'required' => false,
                )
            )
            ->add(
                'extraNormalHour',
                null,
                array(
                    'label' => 'Extra normal',
                    'required' => false,
                )
            )
            ->add(
                'extraExtraHour',
                null,
                array(
                    'label' => 'Extra extra',
                    'required' => false,
                )
            )
            ->add(
                'roadNormalHour',
                null,
                array(
                    'label' => 'Ctra. normal',
                    'required' => false,
                )
            )
            ->add(
                'roadExtraHour',
                null,
                array(
                    'label' => 'Ctra. extra',
                    'required' => false,
                )
            )
            ->add(
                'awaitingHour',
                null,
                array(
                    'label' => 'Espera',
                    'required' => false,
                )
            )
            ->add(
                'negativeHour',
                null,
                array(
                    'label' => 'Negativa',
                    'required' => false,
                )
            )
            ->add(
                'transferHour',
                null,
                array(
                    'label' => 'Transbordament',
                    'required' => false,
                )
            )
            ->end()
        ->with('Dietes i trucades', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'lunch',
                null,
                array(
                    'label' => 'Dinar',
                    'required' => false,
                )
            )
            ->add(
                'dinner',
                null,
                array(
                    'label' => 'Sopar',
                    'required' => false,
                )
            )
            ->add(
                'overNight',
                null,
                array(
                    'label' => 'Pernocta',
                    'required' => false,
                )
            )
            ->add(
                'extraNight',
                null,
                array(
                    'label' => 'Nit extra',
                    'required' => false,
                )
            )
            ->add(
                'diet',
                null,
                array(
                    'label' => 'Dieta',
                    'required' => false,
                )
            )
            ->add(
                'internationalLunch',
                null,
                array(
                    'label' => 'Dinar int.',
                    'required' => false,
                )
            )
            ->add(
                'internationalDinner',
                null,
                array(
                    'label' => 'Sopar int.',
                    'required' => false,
                )
            )
            ->add(
                'truckOutput',
                null,
                array(
                    'label' => 'Sortida camió',
                    'required' => false,
                )
            )
            ->add(
                'carOutput',
                null,
                array(
                    'label' => 'Sortida cotxe',
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
                'group',
                null,
                array(
                    'label' => 'Grup prima',
                )
            )
        ;
    }

    /**
     * @param string $context
     *
     * @return QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = parent::createQuery($context);
        if (!$this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $queryBuilder
                ->andWhere($queryBuilder->getRootAliases()[0].'enterprise = :enterprise')
                ->setParameter('enterprise', $this->getUserLogedEnterprise())
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'group',
                null,
                array(
                    'label' => 'Grup prima',
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
