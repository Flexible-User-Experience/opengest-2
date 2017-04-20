<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactMessageForm.
 */
class ContactMessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Nombre',
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                    ),
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Email',
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Email(array(
                            'strict' => true,
                            'checkMX' => true,
                            'checkHost' => true,
                        )),
                    ),
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'label' => 'Enviar',
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
                'data_class' => 'AppBundle\Entity\ContactMessage',
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_contact_message_type';
    }
}
