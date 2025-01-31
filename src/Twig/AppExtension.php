<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Bundle\SecurityBundle\Security;

class AppExtension extends AbstractExtension
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('reset_panier_if_guest', [$this, 'resetPanierIfGuest'], ['is_safe' => ['html']]),
        ];
    }

    public function resetPanierIfGuest(): string
    {
        if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return '<script>localStorage.setItem("panier", JSON.stringify([]));</script>';
        }

        return '';
    }
}