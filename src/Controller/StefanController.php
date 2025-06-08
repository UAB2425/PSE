<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StefanController extends AbstractController
{
    #[Route('/Stefan', name: 'Stefan')]
    public function index(): Response
    {
        return $this->render('Stefan/index.html.twig'); 
    }
}
