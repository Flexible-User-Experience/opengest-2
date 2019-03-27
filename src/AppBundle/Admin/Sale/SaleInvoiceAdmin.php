<?php

namespace AppBundle\Admin\Sale;

use AppBundle\Admin\AbstractBaseAdmin;
use AppBundle\Entity\Sale\SaleDeliveryNote;
use AppBundle\Entity\Sale\SaleInvoice;
use AppBundle\Entity\Setting\SaleInvoiceSeries;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class SaleInvoicedmin.
 *
 * @category    Admin
 */
class SaleInvoiceAdmin extends AbstractBaseAdmin
{
    /**
     * @var string
     */
    protected $translationDomain = 'admin';

    /**
     * @var string
     */
    protected $classnameLabel = 'Factura';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'vendes/factura';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'date',
        '_sort_order' => 'DESC',
    );

    /**
     * Methods.
     */

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('delete');
    }

    /**
     * @param FormMapper $formMapper
     *
     * @throws \Exception
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.with.general', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'date',
                DatePickerType::class,
                array(
                    'label' => 'admin.label.invoice_date',
                    'format' => 'd/m/Y',
                    'required' => true,
                    'dp_default_date' => (new \DateTime())->format('d/m/Y'),
                )
            )
            ->add(
                'partner',
                ModelAutocompleteType::class,
                array(
                    'property' => 'name',
                    'label' => 'admin.label.partner',
                    'required' => true,
                    'callback' => function ($admin, $property, $value) {
                        /** @var Admin $admin */
                        $datagrid = $admin->getDatagrid();
                        /** @var QueryBuilder $queryBuilder */
                        $queryBuilder = $datagrid->getQuery();
                        $queryBuilder
                            ->andWhere($queryBuilder->getRootAliases()[0].'.enterprise = :enterprise')
                            ->setParameter('enterprise', $this->getUserLogedEnterprise())
                        ;
                        $datagrid->setValue($property, null, $value);
                    },
                )
            )
            ->end()
            ->with('admin.with.delivery_notes', $this->getFormMdSuccessBoxArray(4))
        ;
        if ($this->id($this->getSubject())) { // is edit mode
            $formMapper
                ->add(
                    'deliveryNotes',
                    EntityType::class,
                    array(
                        'label' => 'admin.label.delivery_notes',
                        'required' => false,
                        'class' => SaleDeliveryNote::class,
                        'multiple' => true,
                        'expanded' => true,
                        'query_builder' => $this->rm->getSaleDeliveryNoteRepository()->getFilteredByEnterpriseSortedByNameQB($this->getUserLogedEnterprise()),
                        'by_reference' => false,
                    )
                )
            ;
        } else { // is create mode
            $formMapper
                ->add(
                    'deliveryNotes',
                    EntityType::class,
                    array(
                        'label' => 'admin.label.delivery_notes',
                        'required' => false,
                        'class' => SaleDeliveryNote::class,
                        'multiple' => true,
                        'expanded' => true,
                        'query_builder' => $this->rm->getSaleDeliveryNoteRepository()->getEmptyQueryBuilder(),
                        'by_reference' => false,
                    )
                )
            ;
        }
        $formMapper
            ->end()
            ->with('Import', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'series',
                EntityType::class,
                array(
                    'class' => SaleInvoiceSeries::class,
                    'label' => 'Sèrie de facturació',
                    'query_builder' => $this->rm->getSaleInvoiceSeriesRepository()->getEnabledSortedByNameQB(),
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Tipus',
                    'required' => true,
                )
            )
            ->add(
                'total',
                null,
                array(
                    'label' => 'Total factura',
                    'required' => false,
                )
            )
            ->add(
                'hasBeenCounted',
                null,
                array(
                    'label' => 'Ha estat comptabilitzada',
                    'required' => false,
                )
            )
            ->end()
        ;
        if ($this->id($this->getSubject())) { // is edit mode, disable on new subjetcs
            $formMapper
                ->with('General', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'invoiceNumber',
                    null,
                    array(
                        'label' => 'Número de factura',
                        'disabled' => true,
                    )
                )
                ->end()
                ->with('Import', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'series',
                    EntityType::class,
                    array(
                        'class' => SaleInvoiceSeries::class,
                        'label' => 'Sèrie de facturació',
                        'query_builder' => $this->rm->getSaleInvoiceSeriesRepository()->getEnabledSortedByNameQB(),
                        'disabled' => true,
                    )
                )
                ->end()
            ;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'date',
                'doctrine_orm_date',
                array(
                    'label' => 'Data creació',
                    'field_type' => DatePickerType::class,
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
                'invoiceNumber',
                null,
                array(
                    'label' => 'Núm. factura',
                )
            )
            ->add(
                'series',
                null,
                array(
                    'label' => 'Sèrie factura',
                )
            )
            ->add(
                'type',
                null,
                array(
                    'label' => 'Typus',
                )
            )
            ->add(
                'total',
                null,
                array(
                    'label' => 'Total',
                )
            )
            ->add(
                'hasBeenCounted',
                null,
                array(
                    'label' => 'Ha estat comptabilitzada',
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
            ->andWhere('p.enterprise = :enterprise')
            ->setParameter('enterprise', $this->getUserLogedEnterprise())
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
                'date',
                null,
                array(
                    'label' => 'admin.label.date',
                    'format' => 'd/m/Y',
                )
            )
            ->add(
                'invoiceNumber',
                null,
                array(
                    'label' => 'admin.label.invoice_number',
                    'template' => '::Admin/Cells/list__cell_sale_invoice_full_invoice_number.html.twig',
                )
            )
            ->add(
                'partner',
                null,
                array(
                    'label' => 'admin.label.partner',
                )
            )
            ->add(
                'total',
                null,
                array(
                    'label' => 'admin.label.total',
                )
            )
            ->add(
                'hasBeenCounted',
                null,
                array(
                    'label' => 'admin.label.has_been_counted',
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
                    'label' => 'admin.actions',
                )
            )
        ;
    }

    /**
     * @param SaleInvoice $object
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function prePersist($object)
    {
        $object->setInvoiceNumber($this->getConfigurationPool()->getContainer()->get('app.invoice_manager')->getLastInvoiceNumberBySerieAndEnterprise($object->getSeries(), $this->getUserLogedEnterprise()));
    }

    /**
     * @param SaleInvoice $object
     */
    public function postUpdate($object)
    {
        $totalPrice = 0;
        /** @var SaleDeliveryNote $deliveryNote */
        foreach ($object->getDeliveryNotes() as $deliveryNote) {
            $base = $deliveryNote->getBaseAmount() - ($deliveryNote->getBaseAmount() * $deliveryNote->getDiscount() / 100);
            $totalPrice = $totalPrice + $base;
        }
        $object->setTotal($totalPrice);

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $em->flush();
    }
}
