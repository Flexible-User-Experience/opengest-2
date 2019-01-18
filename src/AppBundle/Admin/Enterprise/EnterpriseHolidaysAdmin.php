<?php

namespace AppBundle\Admin\Enterprise;

use AppBundle\Admin\AbstractBaseAdmin;
use AppBundle\Entity\EnterpriseHolidays;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\DatePickerType;

/**
 * Class EnterpriseHolidaysAdmin.
 *
 * @category    Admin
 *
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class EnterpriseHolidaysAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Dies festius';
    protected $baseRoutePattern = 'empreses/dies-festius';
    protected $datagridValues = array(
        '_sort_by' => 'day',
        '_sort_order' => 'desc',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Dies festius', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'day',
                DatePickerType::class,
                array(
                    'label' => 'Dia festiu',
                    'format' => 'd/M/y',
                    'required' => true,
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'Nom festivitat',
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
                'enterprise',
                null,
                array(
                    'label' => 'Empresa',
                )
            )
            ->add(
                'day',
                'doctrine_orm_date',
                array(
                    'label' => 'Dia festiu',
                    'field_type' => DatePickerType::class,
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'Nom festivitat',
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
            ->addOrderBy($queryBuilder->getRootAliases()[0].'.day', 'DESC')
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
        $listMapper
            ->add(
                'enterprise',
                null,
                array(
                    'label' => 'Empresa',
                )
            )
            ->add(
                'day',
                null,
                array(
                    'label' => 'Dia festiu',
                    'format' => 'd/m/y',
                    'editable' => true,
                )
            )->add(
                'name',
                null,
                array(
                    'label' => 'Nom festivitat',
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

    /**
     * @param EnterpriseHolidays $object
     */
    public function prePersist($object)
    {
        $object->setEnterprise($this->getUserLogedEnterprise());
    }
}
