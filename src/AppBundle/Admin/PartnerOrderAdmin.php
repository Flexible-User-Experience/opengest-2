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
 * Class PartnerOrderAdmin.
 *
 * @category Admin
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class PartnerOrderAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Tercers comandes';
    protected $baseRoutePattern = 'tercers/comandes';
    protected $datagridValues = array(
        '_sort_by' => 'partner',
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
                    'number',
                    null,
                    array(
                        'label' => 'Número comanda',
                        'required' => true,
                    )
                )
                ->add(
                    'providerReference',
                    null,
                    array(
                        'label' => 'Referència proveïdor',
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
                'number',
                null,
                array(
                    'label' => 'Número comanda',
                )
            )
            ->add(
                'providerReference',
                null,
                array(
                    'label' => 'Referència proveïdor',
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
                ->andWhere($queryBuilder->getRootAliases()[0].'.partner.enterprise = :enterprise')
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
                )
            )
            ->add(
                'number',
                null,
                array(
                    'label' => 'Número Comanda',
                    'editable' => true,
                )
            )
            ->add(
                'providerReference',
                null,
                array(
                    'label' => 'Referència proveïdor',
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
