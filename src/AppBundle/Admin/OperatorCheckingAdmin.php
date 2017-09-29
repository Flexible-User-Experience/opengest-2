<?php

namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class OperatorCheckingAdmin.
 *
 * @category Admin
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class OperatorCheckingAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Revisions';
    protected $baseRoutePattern = 'operaris/revisio';
    protected $datagridValues = array(
        '_sort_by' => 'end',
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
            ->with('General', $this->getFormMdSuccessBoxArray(6))
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
                'type',
                null,
                array(
                    'label' => 'Tipus revisió',
                    'required' => true,
                    'query_builder' => $this->rm->getOperatorCheckingTypeRepository()->getEnabledSortedByNameQB(),
                )
            )
            ->add(
                'begin',
                'sonata_type_date_picker',
                array(
                    'label' => 'Data d\'expedició',
                    'format' => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'end',
                'sonata_type_date_picker',
                array(
                    'label' => 'Data de caducitat',
                    'format' => 'd/M/y',
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
                'operator',
                null,
                array(
                    'label' => 'Operador',
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus revisó',
                )
            )
            ->add(
                'begin',
                'doctrine_orm_date',
                array(
                    'label' => 'Data d\'expedició',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
            ->add(
                'end',
                'doctrine_orm_date',
                array(
                    'label' => 'Data caducitat',
                    'field_type' => 'sonata_type_date_picker',
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
        if ($this->acs->isGranted('ROLE_ADMIN')) {
            return $queryBuilder;
        }
        $queryBuilder
            ->join($queryBuilder->getRootAliases()[0].'.operator', 'op')
            ->andWhere('op.enterprise = :enterprise')
            ->setParameter('enterprise', $this->ts->getToken()->getUser()->getDefaultEnterprise())
        ;

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
                'status',
                null,
                array(
                    'label' => 'Estat',
                    'template' => '::Admin/Cells/list__cell_operator_checking_status.html.twig',
                )
            )
            ->add(
                'begin',
                'date',
                array(
                    'label' => 'Data d\'expedició',
                    'format' => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'end',
                'date',
                array(
                    'label' => 'Data caducitat',
                    'format' => 'd/m/Y',
                    'editable' => true,
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
                'type',
                null,
                array(
                    'label' => 'Tipus revisió',
                    'editable' => true,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'type')),
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
