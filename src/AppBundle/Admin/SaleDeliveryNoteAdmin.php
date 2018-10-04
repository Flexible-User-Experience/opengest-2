<?php

namespace AppBundle\Admin;

use AppBundle\Entity\ActivityLine;
use AppBundle\Entity\CollectionDocumentType;
use AppBundle\Entity\PartnerBuildingSite;
use AppBundle\Entity\PartnerOrder;
use AppBundle\Entity\SaleDeliveryNote;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Class SaleDeliveryNoteAdmin.
 *
 * @category    Admin
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class SaleDeliveryNoteAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Albarà';
    protected $baseRoutePattern = 'vendes/albara';
    protected $datagridValues = array(
        '_sort_by' => 'date',
        '_sort_order' => 'DESC',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

        ->with('General', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'date',
                DatePickerType::class,
                array(
                    'label' => 'Data petició',
                    'format' => 'd/M/y',
                    'required' => true,
                    'dp_default_date' => (new \DateTime())->format('d/m/Y'),
                )
            )
            ->add(
                'partner',
                ModelAutocompleteType::class,
                array(
                    'property' => 'name',
                    'label' => 'Client',
                    'required' => true,
                    'callback' => function ($admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $queryBuilder = $datagrid->getQuery();
                        $queryBuilder
                            ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
                            ->setParameter('enterprise', $this->getUserLogedEnterprise())
                        ;
                        $datagrid->setValue($property, null, $value);
                    },
                )
            )
            ->add(
                'buildingSite',
                EntityType::class,
                array(
                    'class' => PartnerBuildingSite::class,
                    'label' => 'Obra',
                    'required' => false,
//                    'query_builder' =>
                )
            )
            ->add(
                'order',
                EntityType::class,
                array(
                    'class' => PartnerOrder::class,
                    'label' => 'Comanda',
                    'required' => false,
//                    'query_builder' =>
                )
            )
            ->add(
                'deliveryNoteNumber',
                null,
                array(
                    'label' => 'Número de comanda',
                    'required' => true,
                )
            )
        ->end()
        ->with('Import', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'baseAmount',
                null,
                array(
                    'label' => 'Import base',
                    'required' => true,
                )
            )
            ->add(
                'discount',
                null,
                array(
                    'label' => 'Descompte',
                    'required' => false,
                )
            )
            ->add(
                'collectionDocument',
                EntityType::class,
                array(
                    'class' => CollectionDocumentType::class,
                    'label' => 'Tipus document cobrament',
                    'required' => false,
//                    'query_builder' =>
                )
            )
            ->add(
                'collectionTerm',
                null,
                array(
                    'label' => 'Venciment (dies)',
                    'required' => true,
                )
            )
            ->add(
                'activityLine',
                EntityType::class,
                array(
                    'class' => ActivityLine::class,
                    'label' => 'Línia d\'activitat',
                    'required' => false,
//                    'query_builder' =>
                )
            )
            ->add(
                'wontBeInvoiced',
                CheckboxType::class,
                array(
                    'label' => 'No facturable',
                    'checked' => false,
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
                'date',
                'doctrine_orm_date',
                array(
                    'label' => 'Data albarà',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
            ->add(
                'partner',
                'doctrine_orm_model_autocomplete',
                array(
                    'label' => 'Client',
                ),
                null,
                array(
                    'property' => 'name',
                )
            )
            ->add(
                'buildingSite',
                null,
                array(
                    'label' => 'Obra',
                )
            )
            ->add(
                'order',
                null,
                array(
                    'label' => 'Comanda',
                )
            )
            ->add(
                'deliveryNoteNumber',
                null,
                array(
                    'label' => 'Número albarà',
                )
            )
            ->add(
                'baseAmount',
                null,
                array(
                    'label' => 'Import base',
                )
            )
            ->add(
                'discount',
                null,
                array(
                    'label' => 'Descompte',
                )
            )
            ->add(
                'collectionTerm',
                null,
                array(
                    'label' => 'Venciment',
                )
            )
            ->add(
                'collectionDocument',
                null,
                array(
                    'label' => 'Tipus document cobrament',
                )
            )
            ->add(
                'activityLine',
                null,
                array(
                    'label' => 'Línia activitat',
                )
            )
            ->add(
                'wontBeInvoiced',
                null,
                array(
                    'label' => 'No facturable',
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
            //deliveryNoteNumber, partner, baseAmount i wontBeInvoiced.

            ->add(
                'date',
                null,
                array(
                    'label' => 'Data albarà',
                )
            )
            ->add(
                'deliveryNoteNumber',
                null,
                array(
                    'label' => 'Número albarà',
                )
            )
            ->add(
                'partner',
                null,
                array(
                    'label' => 'Client',
                )
            )
            ->add(
                'baseAmount',
                null,
                array(
                    'label' => 'Import base',
                )
            )
            ->add(
                'wontBeInvoiced',
                null,
                array(
                    'label' => 'No facturable',
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
     * @param SaleDeliveryNote $object
     */
    public function prePersist($object)
    {
        $object->setEnterprise($this->getUserLogedEnterprise());
    }
}
