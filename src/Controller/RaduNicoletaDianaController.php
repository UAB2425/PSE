<?php
// src/Controller/RaduNicoletaDianaController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaduNicoletaDianaController extends AbstractController
{
    #[Route('/RaduNicoletaDiana', name: 'radu_nicoletadiana')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('RaduNicoletaDiana/index.html.twig');
    }
}
