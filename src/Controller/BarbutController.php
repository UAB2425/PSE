<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarbutController extends AbstractController
{
    #[Route('/Barbut', name: 'barbut')]
    public function personalPage(): Response
    {
        return $this->render('Barbut/barbut.html.twig');
    }
}