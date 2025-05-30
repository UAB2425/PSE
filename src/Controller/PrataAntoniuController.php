<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrataAntoniuController extends AbstractController
{
    #[Route('/PrataAntoniu', name: 'prata_antoniu_hero')]
    public function heroPage(): Response
    {
        return $this->render('PrataAntoniu/hero.html.twig');
    }
}