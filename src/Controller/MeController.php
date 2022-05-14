<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController {


    public function __invoke()
    {
        $user = $this->getUser();
        return $user;
    }
}