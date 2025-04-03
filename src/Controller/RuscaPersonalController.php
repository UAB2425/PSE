<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RuscaPersonalController extends AbstractController
{
    #[Route('/bogdan_rusca/hero', name: 'bogdan_rusca_hero')]
    public function heroPage(): Response
    {
        return $this->render('bogdan_rusca/hero.html.twig');
    }
}
