<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CocerbaController extends AbstractController
{
    #[Route('/cocerba', name: 'app_cocerba')]
    public function index(): Response
    {
        return $this->render('cocerba/alex.html.twig', [
            'controller_name' => 'CocerbaController',
        ]);
    }
}
