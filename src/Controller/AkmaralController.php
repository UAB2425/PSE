<?php

namespace App\Controller;

use App\Repository\AkmaralSeyidovaAboutMeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AkmaralController extends AbstractController
{
    #[Route('/akmaral', name: 'app_akmaral')]
    public function index(AkmaralSeyidovaAboutMeRepository $repository): Response
    {
        // En son eklenen kaydı al (id'ye göre ters sırala)
        $about = $repository->findOneBy([], ['id' => 'DESC']);

        return $this->render('akmaral/index.html.twig', [
            'about' => $about,
        ]);
    }
}
