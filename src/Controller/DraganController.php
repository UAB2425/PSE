<?php
// src/Controller/DraganController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DraganController extends AbstractController
{
	#[Route('/Dragan/Hero')]
    public function Hero(): Response
    {
        return $this->render('Dragan/Hero.html.twig');
    }
}