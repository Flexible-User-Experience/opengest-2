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
 * Class EnterpriseTransferAccountAdmin.
 *
 * @category    Admin
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class EnterpriseTransferAccountAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Compte Bancari';
    protected $baseRoutePattern = 'empreses/compte-bancari';
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

        ->with('Nom', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'enterprise',
                EntityType::class,
                array(
                    'label' => 'Empresa',
                    'required' => true,
                    'class' => Enterprise::class,
                    'query_builder' => $this->rm->getEnterpriseRepository()->getEnterprisesByUserQB($this->getUser()),
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
        ->end()
        ->with('Compte Bancari', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'iban',
                null,
                array(
                    'label' => 'IBAN',
                    'required' => false,
                )
            )
            ->add(
                'swift',
                null,
                array(
                    'label' => 'SWIFT',
                    'required' => false,
                )
            )
            ->add(
                'bankCode',
                null,
                array(
                    'label' => 'Codi Entitat',
                    'required' => false,
                )
            )
            ->add(
                'officeNumber',
                null,
                array(
                    'label' => 'Codi Oficina',
                    'required' => false,
                )
            )
            ->add(
                'controlDigit',
                null,
                array(
                    'label' => 'Digit de control',
                    'required' => false,
                )
            )
            ->add(
                'accountNumber',
                null,
                array(
                    'label' => 'Número de compte',
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
                'name',
                null,
                array(
                    'label' => 'Nom',
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
                'name',
                null,
                array(
                    'label' => 'Nom',
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
