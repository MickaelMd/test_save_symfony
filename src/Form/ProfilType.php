<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]+$/',
                        'message' => 'Le nom ne doit contenir que des lettres.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]+$/',
                        'message' => 'Le prénom ne doit contenir que des lettres.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom.',
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(\+33|0)[1-9](\d{2}){4}$/',
                        'message' => 'Le numéro de téléphone doit être valide.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer un numéro de téléphone.',
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre adresse.',
                    ]),
                ],
            ])
            ->add('cp', TextType::class, [
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Le code postal doit être un nombre à 5 chiffres.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer un code postal.',
                    ]),
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]+$/',
                        'message' => 'Le nom de la ville ne doit contenir que des lettres.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer le nom de votre ville.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}