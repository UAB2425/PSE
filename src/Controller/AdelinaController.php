<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdelinaController extends AbstractController
{
    #[Route('/adelina', name: 'adelina_page')]
    public function index(): Response
    {
        return $this->render('adelina/Adelina.html.twig');
    }
}
