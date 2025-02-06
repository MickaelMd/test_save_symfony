<?php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ProfilEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'constraints' => [new NotBlank()],
                'mapped' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'mapped' => true,
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse e-mail que vous avez saisie n\'est pas valide.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse e-mail.',
                    ]),
                ],
            ])
           
           ;
    }
}