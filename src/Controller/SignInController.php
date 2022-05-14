<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class SignInController extends AbstractController
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {}

    public function __invoke(User $data) 
    {
        $hashPassword = $this->passwordHasher->hashPassword($data, $data->getPassword());
        $data->setPassword($hashPassword);

        return $data;
    }
    
}