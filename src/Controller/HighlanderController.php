<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HighlanderController extends AbstractController
{
	#[Route(path: 'highlander/hero', name: 'highlander-hero')]
    public function index(): Response
    {
        return $this->render('highlander/hero.html.twig');
    }
}