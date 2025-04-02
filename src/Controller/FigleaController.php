<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FigleaController extends AbstractController{
    #[Route('/Figlea', name: 'page_figlea')]
    public function index(): Response
    {
        return $this->render('Figlea/index.html.twig', [
            'controller_name' => 'FigleaController',
        ]);
    }
}
