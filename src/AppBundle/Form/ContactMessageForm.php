<?php

namespace AppBundle\Form;

use AppBundle\Entity\Web\ContactMessage;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactMessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Nombre *',
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
                        'placeholder' => 'Email *',
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
                'phone',
                TextType::class,
                array(
                    'label' => false,
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Teléfono',
                    ),
                )
            )
            ->add(
                'message',
                TextareaType::class,
                array(
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'rows' => 5,
                        'placeholder' => 'Mensaje *',
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                    ),
                )
            )
            ->add(
                'privacy',
                CheckboxType::class,
                array(
                    'required' => true,
                    'mapped' => false,
                )
            )
//            ->add(
//                'captcha',
//                RecaptchaType::class,
//                array(
//                    'mapped' => false,
//                    'label' => false,
//                    'constraints' => array(
//                        new Recaptcha2(),
//                    ),
//                )
//            )
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
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            array(
                'data_class' => ContactMessage::class,
            )
        );
    }

    public function getBlockPrefix(): string
    {
        return 'app_bundle_contact_message_type';
    }
}
