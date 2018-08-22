<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Partner;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class PartnerContactAdmin.
 *
 * @category Admin
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class PartnerContactAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Tercers contacte';
    protected $baseRoutePattern = 'tercers/contacte';
    protected $datagridValues = array(
        '_sort_by' => 'partner.name',
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
                    'partner',
                    EntityType::class,
                    array(
                        'class' => Partner::class,
                        'label' => 'Tercer',
                        'required' => true,
                        'query_builder' => $this->rm->getPartnerRepository()->getFilteredByEnterpriseEnabledSortedByNameQB($this->getUserLogedEnterprise()),
                    )
                )
                ->add(
                    'name',
                    null,
                    array(
                        'label' => 'Nom',
                        'required' => true,
                    )
                )
                ->add(
                    'phone',
                    null,
                    array(
                        'label' => 'Telèfon',
                        'required' => false,
                    )
                )
                ->add(
                    'fax',
                    null,
                    array(
                        'label' => 'Fax',
                        'required' => false,
                    )
                )
                ->add(
                    'notes',
                    null,
                    array(
                        'label' => 'Notes',
                        'required' => false,
                        'attr' => array(
                            'style' => 'resize: vertical',
                            'rows' => 7,
                        ),
                    )
                )
            ->end()
            ->with('Càrrec', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'care',
                    null,
                    array(
                        'label' => 'Càrrec',
                        'required' => false,
                    )
                )
                ->add(
                    'mobile',
                    null,
                    array(
                        'label' => 'Mòbil',
                        'required' => false,
                    )
                )
                ->add(
                    'email',
                    null,
                    array(
                        'label' => 'Email',
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
                'partner',
                null,
                array(
                    'label' => 'Tercer',
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
                'care',
                null,
                array(
                    'label' => 'Càrrec',
                )
            )
            ->add(
                'phone',
                null,
                array(
                    'label' => 'Telèfon',
                )
            )
            ->add(
                'mobile',
                null,
                array(
                    'label' => 'Mòbil',
                )
            )
            ->add(
                'fax',
                null,
                array(
                    'label' => 'Fax',
                )
            )
            ->add(
                'notes',
                null,
                array(
                    'label' => 'Notes',
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
            ->join($queryBuilder->getRootAliases()[0].'.partner', 'p')
            ->orderBy('p.name', 'ASC')
        ;
        $queryBuilder->addOrderBy($queryBuilder->getRootAliases()[0].'.name', 'ASC');

        if (!$this->acs->isGranted(UserRolesEnum::ROLE_ADMIN)) {
            $queryBuilder
                ->andWhere('p.enterprise = :enterprise')
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
                'partner',
                null,
                array(
                    'label' => 'Tercer',
                    'editable' => false,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'partner')),
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
                'care',
                null,
                array(
                    'label' => 'Càrrec',
                    'editable' => true,
                )
            )
            ->add(
                'phone',
                null,
                array(
                    'label' => 'Telèfon',
                    'editable' => true,
                )
            )
            ->add(
                'mobile',
                null,
                array(
                    'label' => 'Mòbil',
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