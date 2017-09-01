<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserDefaultEnterpriseForm.
 */
class UserDefaultEnterpriseForm extends AbstractType
{
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
                'plainPassword',
                PasswordType::class,
                array(
                    'label' => 'Contrasenya',
                    'required' => false,
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
                'email',
                EmailType::class,
                array(
                    'label' => 'Cognoms',
                    'disabled' => true,
                )
            )
            ->add(
                'defaultEnterprise',
                EntityType::class,
                array(
                    'label' => 'Empresa',
                    'class' => 'AppBundle:Enterprise',
                    'choice_label' => 'name',
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'label' => 'Enviar',
                    'attr' => array(
                        'class' => 'btn btn-primary no-m-bottom',
                        'style' => 'margin-bottom: -15px',
                    ),
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\User',
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
