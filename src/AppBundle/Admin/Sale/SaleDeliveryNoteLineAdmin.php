<?php

namespace AppBundle\Admin\Sale;

use AppBundle\Admin\AbstractBaseAdmin;
use AppBundle\Entity\Sale\SaleDeliveryNote;
use AppBundle\Enum\ConstantsEnum;
use AppBundle\Enum\UserRolesEnum;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class SaleDeliveryNoteLineAdmin.
 *
 * @category    Admin
 *
 * @auhtor      Rubèn Hierro <info@rubenhierro.com>
 */
class SaleDeliveryNoteLineAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Albarà línia';
    protected $baseRoutePattern = 'vendes/albara-linia';
    protected $datagridValues = array(
        '_sort_by' => 'id',
        '_sort_order' => 'ASC',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Albarà línia', $this->getFormMdSuccessBoxArray(12))
            ->add(
                'deliveryNote',
                EntityType::class,
                array(
                    'class' => SaleDeliveryNote::class,
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'style' => 'display:none;',
                    ),
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
                'priceUnit',
                null,
                array(
                    'label' => 'Preu unitat',
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
                'iva',
                null,
                array(
                    'label' => 'IVA',
                    'required' => true,
                    'empty_data' => (string) ConstantsEnum::IVA,
                    'attr' => array(
                        'placeholder' => ConstantsEnum::IVA,
                    ),
                )
            )
            ->add(
                'irpf',
                null,
                array(
                    'label' => 'IRPF',
                    'required' => true,
                    'empty_data' => (string) ConstantsEnum::IRPF,
                    'attr' => array(
                        'placeholder' => ConstantsEnum::IRPF,
                    ),
                )
            )
            ->add(
                'total',
                null,
                array(
                    'label' => 'Total',
                    'required' => false,
                    'disabled' => true,
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
                'deliveryNote',
                null,
                array(
                    'label' => 'Albarà',
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
                'priceUnit',
                null,
                array(
                    'label' => 'Preu unitat',
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
                'discount',
                null,
                array(
                    'label' => 'Descompte',
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
                'iva',
                null,
                array(
                    'label' => 'IVA',
                )
            )
            ->add(
                'irpf',
                null,
                array(
                    'label' => 'IRPF',
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
                ->join($queryBuilder->getRootAliases()[0].'.deliveryNote', 's')
                ->where('s.enterprise = :enterprise')
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
                'deliveryNote',
                null,
                array(
                    'label' => 'Albarà',
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
                'priceUnit',
                null,
                array(
                    'label' => 'Preu unitat',
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
                'discount',
                null,
                array(
                    'label' => 'Descompte',
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
                'iva',
                null,
                array(
                    'label' => 'IVA',
                )
            )
            ->add(
                'irpf',
                null,
                array(
                    'label' => 'IRPF',
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
