<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IoanValetinaPersonalPageController extends AbstractController
{
 
    public function showPersonalPage(): Response
    {
        return $this->render('personal/ioan_valentina.html.twig', [
            'random_number' => rand(0, 100) 
        ]);
    }
}