<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DarkInVioletController extends AbstractController{
    #[Route('/dark_in_violet', name: 'DarkInViolet')]
    public function index(): Response
    {
        return $this->render('dark_in_violet/DarkInViolet.html.twig', [
            'controller_name' => 'DarkInVioletController',
        ]);
    }
}
