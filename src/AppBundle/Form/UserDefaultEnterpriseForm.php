<?php

namespace AppBundle\Form;

use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Setting\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserDefaultEnterpriseForm extends AbstractType
{
    private EntityManagerInterface $em;
    private TokenStorageInterface $ts;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $ts)
    {
        $this->em = $em;
        $this->ts = $ts;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
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
                    'class' => Enterprise::class,
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class,
            )
        );
    }

    public function getBlockPrefix(): string
    {
        return 'app_bundle_user_default_enterprise';
    }
}
