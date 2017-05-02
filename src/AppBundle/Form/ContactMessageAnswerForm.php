<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class ContactMessageAnswerType.
 *
 * @category FormType
 *
 * @author   David Romaní <david@flux.cat>
 */
class ContactMessageAnswerForm extends ContactMessageForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'answer',
                TextareaType::class,
                array(
                    'label' => 'Respuesta',
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
                    'label' => 'Enviar',
                    'attr' => array(
                        'class' => 'btn-primary',
                    ),
                )
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact_message_answer';
    }
}
