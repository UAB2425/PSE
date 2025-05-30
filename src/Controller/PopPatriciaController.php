<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PopPatriciaController extends AbstractController
{
    #[Route('/pop/patricia', name: 'app_pop_patricia')]
    public function index(): Response
    {
        return $this->render('pop_patricia/index.html.twig', [
            'controller_name' => 'PopPatriciaController',
        ]);
    }
}