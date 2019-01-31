<?php

namespace AppBundle\Form;

use AppBundle\Entity\Setting\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserDefaultEnterpriseForm.
 */
class UserDefaultEnterpriseForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TokenStorage
     */
    private $ts;

    /**
     * Methods.
     */

    /**
     * UserDefaultEnterpriseForm constructor.
     *
     * @param EntityManager $em
     * @param TokenStorage  $ts
     */
    public function __construct(EntityManager $em, TokenStorage $ts)
    {
        $this->em = $em;
        $this->ts = $ts;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                array(
                    'label' => 'Nom d\'usuari',
                    'disabled' => true,
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'label' => 'Email',
                    'disabled' => true,
                )
            )
            ->add(
                'firstname',
                TextType::class,
                array(
                    'label' => 'Nom',
                    'required' => true,
                )
            )
            ->add(
                'lastname',
                TextType::class,
                array(
                    'label' => 'Cognoms',
                    'required' => true,
                )
            )
            ->add(
                'defaultEnterprise',
                EntityType::class,
                array(
                    'label' => 'Empresa',
                    'class' => 'AppBundle:Enterprise',
                    'query_builder' => $this->em->getRepository('AppBundle:Enterprise\Enterprise')->getEnterprisesByUserQB($this->ts->getToken()->getUser()),
                    'choice_label' => 'name',
                )
            )
            ->add(
                'mainImageFile',
                FileType::class,
                array(
                    'label' => ' ',
                    'required' => false,
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'label' => 'Actualitzar',
                    'attr' => array(
                        'class' => 'btn btn-success no-m-bottom',
                    ),
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class,
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_user_default_enterprise';
    }
}
