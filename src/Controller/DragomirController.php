<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DragomirController extends AbstractController{
    #[Route('/dragomir', name: 'app_dragomir')]
    public function index(): Response
    {
        $name = "Dragomir Naomi-Elena";

        return $this->render('dragomir/index.html.twig', [
            'controller_name' => 'DragomirController',
            'name' => $name
        ]);
    }
}
