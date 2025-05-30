<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CryController extends AbstractController
{
    #[Route('/RaduP', name: 'cry')]
    public function personalPage(): Response
    {
        $name = "Goro Majima";
        $paragraphs = [
            "Goro Majima, known as the 'Mad Dog of Shimano,' is a legendary figure in the *Yakuza* series, first introduced in the original game. With his distinctive eyepatch and unpredictable behavior, he serves as both a formidable antagonist and a complex ally to protagonist Kazuma Kiryu. Majima’s loyalty to the Tojo Clan is tested through his tumultuous relationship with his former boss, Shimano, and his brotherly bond with Kiryu, making him a fan-favorite character with a rich backstory.",
            "Beyond his combat prowess, Majima’s eccentric personality shines through his love for chaos, dance battles, and his signature weapon—a sharpened baseball bat. His snake tattoo, a symbol of his wild spirit, and his dual nature as both a yakuza enforcer and a theatrical showman add depth to his character. Whether he’s challenging Kiryu to a fight or running his cabaret club, Majima’s presence is unforgettable.",
           
        ];
        $interests = ['Combat mastery', 'Cabaret management', 'Unpredictable antics', 'Loyalty to Tojo Clan'];

        return $this->render('RaduP/cry.html.twig', [
            'name' => $name,
            'paragraphs' => $paragraphs,
            'interests' => $interests,
            'image_path' => 'images/Goro.png'
        ]);
    }
}