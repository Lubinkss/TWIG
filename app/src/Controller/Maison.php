<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class Maison extends AbstractController

{   #[Route('/maison/{qui}')]
    public function maison(string $qui = 'Mickey'): Response {
        return $this->render('hello.html.twig');
    }


}