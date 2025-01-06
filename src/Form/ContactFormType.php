<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;  // Import du bon type
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [  // Utilisation de EmailType::class
                'constraints' => [
                    new Assert\Email(['message' => 'L\'adresse email n\'est pas valide.']),
                    new Assert\NotBlank(['message' => 'L\'email ne peut pas être vide.'])
                ]
            ])
            ->add('objet', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le sujet ne peut pas être vide.'])
                ]
            ])
            ->add('message', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le message ne peut pas être vide.'])
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