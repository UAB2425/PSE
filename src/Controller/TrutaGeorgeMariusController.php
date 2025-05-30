<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrutaGeorgeMariusController extends AbstractController
{
    #[Route('/Truta-George-Marius', name: 'Truta_George_Marius')]
    public function index(): Response
    {
        return $this->render('Truta_George_Marius/index.html.twig'); 
    }
}
