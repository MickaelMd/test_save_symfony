<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse e-mail que vous avez saisie n\'est pas valide.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse e-mail.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => false,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez confirmer votre mot de passe.',
                    ]),
                    new Callback([$this, 'validatePasswordConfirmation']),
                ],
            ])
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
    public function validatePasswordConfirmation($confirmPassword, ExecutionContextInterface $context)
{
    $password = $context->getRoot()->get('password')->getData();

    if ($confirmPassword !== $password) {
        $context->buildViolation('Les mots de passe ne correspondent pas.')
            ->atPath('confirmPassword')
            ->addViolation();
    }
}
}