<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LascusController extends AbstractController
{
    #[Route('/Lascus-Rut', name: 'lascus_rut')]
    public function personalPage(): Response
    {
        return $this->render('Lascus/lascus.html.twig');
    }
}