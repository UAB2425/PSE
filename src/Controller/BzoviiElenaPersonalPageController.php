<?php
// src/Controller/BzoviiElenaController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BzoviiElenaPersonalPageController extends AbstractController
{
    #[Route('/Bzovii/Elena', name: 'bzovii_elena')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        // return new Response(
        //     '<html><body>Lucky number: ' . $number . '</body></html>'
        // );
        return $this->render('bzoviielena.html.twig');
    }
}
