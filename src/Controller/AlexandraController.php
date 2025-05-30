<?php
// src/Controller/AlexandraController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlexandraController extends AbstractController
{
    #[Route('/alexandra', name: 'alexandra')]
    public function index(): Response
    {
        return $this->render('alexandra/index.html.twig');
    }
}
