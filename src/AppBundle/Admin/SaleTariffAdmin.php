<?php

namespace AppBundle\Admin;

use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class SaleTariffAdmin.
 *
 * @category    Admin
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class SaleTariffAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Tarifa';
    protected $baseRoutePattern = 'vendes/tarifa';
    protected $datagridValues = array(
        '_sort_by' => 'enterprise.name',
        '_sort_order' => 'ASC',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

        ->with('General', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'year',
                null,
                array(
                    'label' => 'Any',
                    'required' => true,
                )
            )
            ->add(
                'tonnage',
                null,
                array(
                    'label' => 'Tonatge',
                    'required' => true,
                )
            )
        ->end()
        ->with('Tarifa', $this->getFormMdSuccessBoxArray(4))

            ->add(
                'priceHour',
                null,
                array(
                    'label' => 'Preu hora',
                    'required' => false,
                )
            )
            ->add(
                'miniumHours',
                null,
                array(
                    'label' => 'Mínim hores',
                    'required' => false,
                )
            )
            ->add(
                'miniumHolidayHours',
                null,
                array(
                    'label' => 'Mínim hores vacances',
                    'required' => false,
                )
            )
            ->add(
                'displacement',
                null,
                array(
                    'label' => 'Desplaçament',
                    'required' => false,
                )
            )
            ->add(
                'increaseForHolidays',
                null,
                array(
                    'label' => 'Increment per vacances',
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
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
        $datagridMapper

            ->add(
                'year',
                null,
                array(
                    'label' => 'Any',
                )
            )
            ->add(
                'tonnage',
                null,
                array(
                    'label' => 'Tonatge',
                )
            )
            ->add(
                'priceHour',
                null,
                array(
                    'label' => 'Preu hora',
                )
            )
            ->add(
                'miniumHours',
                null,
                array(
                    'label' => 'Mínim hores',
                )
            )
            ->add(
                'miniumHolidayHours',
                null,
                array(
                    'label' => 'Mínim hores vacances',
                )
            )
            ->add(
                'displacement',
                null,
                array(
                    'label' => 'Desplaçament',
                )
            )
            ->add(
                'increaseForHolidays',
                null,
                array(
                    'label' => 'Increment per vacances',
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
        $queryBuilder
            ->join($queryBuilder->getRootAliases()[0].'.enterprise', 'e')
            ->orderBy('e.name', 'ASC')
        ;
        $queryBuilder
            ->addOrderBy($queryBuilder->getRootAliases()[0].'.year', 'DESC')
            ->addOrderBy($queryBuilder->getRootAliases()[0].'.tonnage', 'DESC')
        ;
        if (!$this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $queryBuilder
                ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
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
        if ($this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $listMapper
                ->add(
                    'enterprise',
                    null,
                    array(
                        'label' => 'Empresa',
                    )
                )
            ;
        }
        $listMapper
            ->add(
                'year',
                null,
                array(
                    'label' => 'Any',
                )
            )
            ->add(
                'tonnage',
                null,
                array(
                    'label' => 'Tonnatge',
                )
            )
            ->add(
                'priceHour',
                null,
                array(
                    'label' => 'Preu hora',
                )
            )
            ->add(
                'miniumHours',
                null,
                array(
                    'label' => 'Mínim hores',
                )
            )
            ->add(
                'miniumHolidayHours',
                null,
                array(
                    'label' => 'Mínim hores vacances',
                )
            )
            ->add(
                'displacement',
                null,
                array(
                    'label' => 'Desplaçament',
                )
            )
            ->add(
                'increaseForHolidays',
                null,
                array(
                    'label' => 'Increment per vacances',
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

    /**
     * @param $object
     */
    public function prePersist($object)
    {
        $object->setEnterprise($this->getUserLogedEnterprise());
    }
}
