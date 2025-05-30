<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PetruLazarController extends AbstractController
{
    #[Route(path: "petrulazar", name: "petrulazar_hero")]
    public function hero() : Response
    {
        return $this->render("petrulazar/hero.html.twig");
    }
}