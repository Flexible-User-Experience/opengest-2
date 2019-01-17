<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Operator;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class OperatorVariousAmountAdmin.
 *
 * @category Admin
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class OperatorVariousAmountAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Imports varis';
    protected $baseRoutePattern = 'operaris/imports-varis';
    protected $datagridValues = array(
        '_sort_by' => 'date',
        '_sort_order' => 'desc',
    );

    /**
     * @param FormMapper $formMapper
     *
     * @throws \Exception
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'operator',
                EntityType::class,
                array(
                    'label' => 'Operador',
                    'required' => true,
                    'class' => 'AppBundle:Operator',
                    'choice_label' => 'fullName',
                    'query_builder' => $this->rm->getOperatorRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'date',
                DatePickerType::class,
                array(
                    'label' => 'Data',
                    'required' => true,
                    'format' => 'd/M/y',
                    'dp_default_date' => (new \DateTime())->format('d/m/Y'),
                )
            )
            ->add(
                'units',
                null,
                array(
                    'label' => 'Unitats',
                    'required' => false,
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label' => 'Descripció',
                    'required' => false,
                )
            )
            ->add(
                'priceUnit',
                null,
                array(
                    'label' => 'Preu unitat',
                    'required' => false,
                )
            )
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
                    'operator.enterprise',
                    null,
                    array(
                        'label' => 'Empresa',
                    )
                )
            ;
        }
        $datagridMapper
            ->add(
                'operator',
                null,
                array(),
                EntityType::class,
                array(
                    'class' => Operator::class,
                    'label' => 'Operador',
                    'query_builder' => $this->rm->getOperatorRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                )
            )
            ->add(
                'date',
                'doctrine_orm_date',
                array(
                    'label' => 'Data',
                    'field_type' => DatePickerType::class,
                )
            )
            ->add(
                'units',
                null,
                array(
                    'label' => 'Unitats',
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
                'priceUnit',
                null,
                array(
                    'label' => 'Preu unitat',
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
                ->join($queryBuilder->getRootAliases()[0].'.operator', 'op')
                ->andWhere('op.enterprise = :enterprise')
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
                    'operator.enterprise',
                    null,
                    array(
                        'label' => 'Empresa',
                    )
                )
            ;
        }
        $listMapper
            ->add(
                'date',
                'date',
                array(
                    'label' => 'Data',
                    'format' => 'd/m/Y',
                    'editable' => false,
                )
            )
            ->add(
                'operator',
                null,
                array(
                    'label' => 'Operador',
                    'editable' => false,
                    'associated_property' => 'fullName',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'surname1'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'operator')),
                )
            )
            ->add(
                'units',
                null,
                array(
                    'label' => 'Unitats',
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
                'priceUnit',
                null,
                array(
                    'label' => 'Preu unitat',
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'edit' => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                    'label' => 'Accions',
                )
            )
        ;
    }
}
