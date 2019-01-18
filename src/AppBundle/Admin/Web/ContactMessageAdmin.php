<?php

namespace AppBundle\Admin\Web;

use AppBundle\Admin\AbstractBaseAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class ContactMessageAdmin.
 *
 * @category    Admin
 *
 * @author Wils Iglesias <wiglesias83@gmail.com>
 */
class ContactMessageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Missatge de contacte';
    protected $baseRoutePattern = 'web/missatge-contacte';
    protected $datagridValues = array(
        '_sort_by' => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('delete')
            ->remove('batch')
            ->add('answer', $this->getRouterIdParameter().'/answer')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'checked',
                null,
                array(
                    'label' => 'Llegit',
                )
            )
            ->add(
                'createdAt',
                'doctrine_orm_date',
                array(
                    'label' => 'Data creació',
                    'field_type' => DatePickerType::class,
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
                'email',
                null,
                array(
                    'label' => 'Email',
                )
            )
            ->add(
                'answer',
                null,
                array(
                    'label' => 'Resposta',
                )
            )
            ->add(
                'message',
                null,
                array(
                    'label' => 'Missatge',
                )
            )
            ->add(
                'answered',
                null,
                array(
                    'label' => 'Contestat',
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add(
                'checked',
                null,
                array(
                    'label' => 'Llegit',
                )
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label' => 'Data creació',
                    'format' => 'd/m/Y H:i',
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
                'email',
                null,
                array(
                    'label' => 'Email',
                )
            )
            ->add(
                'message',
                TextareaType::class,
                array(
                    'label' => 'Missatge',
                )
            )
            ->add(
                'answered',
                null,
                array(
                    'label' => 'Contestat',
                )
            )
        ;
        if ($this->getSubject()->getAnswered()) {
            $showMapper
                ->add(
                    'answer',
                    'textarea',
                    array(
                        'label' => 'Resposta',
                    )
                )
            ;
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'checked',
                null,
                array(
                    'label' => 'Llegit',
                )
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label' => 'Data creació',
                    'format' => 'd/m/Y',
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
                'email',
                null,
                array(
                    'label' => 'Email',
                )
            )
            ->add(
                'answered',
                null,
                array(
                    'label' => 'Contestat',
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array(
                            'template' => '::Admin/Buttons/list__action_show_button.html.twig',
                        ),
                        'answer' => array(
                            'template' => '::Admin/Cells/list__action_answer.html.twig',
                        ),
                    ),
                    'label' => 'Accions',
                )
            )
        ;
    }
}
