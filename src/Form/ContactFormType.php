<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;  
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email(['message' => 'L\'adresse email n\'est pas valide.']),
                    new Assert\NotBlank(['message' => 'L\'email ne peut pas être vide.']),
                ]
            ])
            ->add('objet', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le sujet ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9À-ÿ .,\-!"?()@#&%$:+\/=]{1,50}$/',
                        'message' => 'Le sujet contient des caractères invalides.',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le sujet ne peut pas dépasser 50 caractères.',
                    ]),
                ]
            ])
            ->add('message', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le message ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9À-ÿ .,\-!"?()@#&%$:+\/=]{1,500}$/',
                        'message' => 'Le message contient des caractères invalides.',
                    ]),
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Le message ne peut pas dépasser 500 caractères.',
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}