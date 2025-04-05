<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LucianyckController extends AbstractController
{
    #[Route('/lucianyck', name: 'app_lucianyck')]
    public function index(): Response
    {
        return $this->render('lucianyck/index.html.twig', [
            'controller_name' => 'LucianyckController',
        ]);
    }
}
