<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PodarController extends AbstractController
{
    #[Route('/podar', name: 'app_podar')]
    public function index(): Response
    {
        return $this->render('Podar/dumitru.html.twig', [
            'controller_name' => 'PodarController',
        ]);
    }
}
