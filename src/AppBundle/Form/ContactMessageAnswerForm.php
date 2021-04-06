<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactMessageAnswerForm extends ContactMessageForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'answer',
                TextareaType::class,
                array(
                    'label' => 'admin.label.answer',
                    'translation_domain' => 'admin',
                    'required' => true,
                    'attr' => array(
                        'rows' => 6,
                    ),
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'label' => 'admin.label.send',
                    'translation_domain' => 'admin',
                    'attr' => array(
                        'class' => 'btn-primary',
                    ),
                )
            )
        ;
    }

    public function getName(): string
    {
        return 'contact_message_answer';
    }
}
