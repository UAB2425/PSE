<?php
// src/Controller/IonutController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IonutController extends AbstractController
{
    #[Route('/ionut', name: 'ionut')]
    public function index(): Response
    {
        return $this->render('ionut/index.html.twig');
    }
}