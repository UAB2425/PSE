<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GuiaController extends AbstractController
{
    #[Route('/Guia_Vlad', name: 'app_name')]
    public function index(): Response
    {
        return $this->render('name/index.html.twig', [
            'controller_name' => 'GuiaController',
        ]);
    }
}
