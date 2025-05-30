<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TomaLaurentiuController extends AbstractController
{
    #[Route('/toma-laurentiu', name: 'toma-laurentiu')]
    public function personalPage(): Response
    {
        return $this->render('Toma_Laurentiu/personalPage.html.twig');
    }
}