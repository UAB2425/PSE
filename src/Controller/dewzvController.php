<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class dewzvController extends AbstractController{
    #[Route('/dewzv', name: 'dewzv')]
    public function index(): Response
    {
        return $this->render('dewzv/dewzv.html.twig', [
            'controller_name' => 'dewzvController',
        ]);
    }
}