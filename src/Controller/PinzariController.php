<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 
class PinzariController extends AbstractController
{
    #[Route('/Pinzari', name:'pinzari_route')]
    public function index() : Response
    {
       $contents = $this->renderView('Pinzari/Pinzari.html.twig');
       return new Response($contents);
       #return new Response('<h1>Hello, Symfony!</h1>');
    }
 
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return new Response('<h1>Homepage route working!</h1>');
    }
}