<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AkmaralController extends AbstractController{
    #[Route('/akmaral', name: 'app_akmaral')]
    public function index(): Response
    {
        return $this->render('akmaral/index.html.twig', [
            'controller_name' => 'AkmaralController',
        ]);
    }
}
