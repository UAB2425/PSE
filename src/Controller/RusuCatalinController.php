<?php

// src/Controller/RusuCatalinController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RusuCatalinController extends AbstractController
{
    #[Route('/RusuCatalin', name: 'Rusu')]
    public function index(): Response
    {
        return $this->render('Rusu/index.html.twig', [
            'name' => 'Rusu Catalin',
        ]);
    }
}