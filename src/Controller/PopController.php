<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PopController extends AbstractController
{
    #[Route('/ovidiupop', name:'ovidiu_route')]
    public function index() : Response
    {
       $contents = $this->renderView('ovidiupop/ovidiup.html.twig');
       return new Response($contents);
       #return new Response('<h1>Hello, Symfony!</h1>');
    }

    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return new Response('<h1>Homepage route working!</h1>');
    }
}