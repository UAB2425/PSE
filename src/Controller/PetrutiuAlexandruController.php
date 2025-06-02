<?php

namespace App\Controller;

use App\Entity\PetrutiuContent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PetrutiuAlexandruController extends AbstractController
{
    #[Route('/petrutiu', name: 'petrutiu_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $content = $em->getRepository(PetrutiuContent::class)->findOneBy([]);
        return $this->render('petrutiu/index.html.twig', [
            'content' => $content,
        ]);
    }

    #[Route('/petrutiu/login', name: 'petrutiu_login')]
    public function login(Request $request, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $user = $request->request->get('username');
            $pass = $request->request->get('password');

            if ($user === 'admin' && $pass === '1234') {
                $session->set('auth', true);
                return $this->redirectToRoute('petrutiu_edit');
            }
        }

        return $this->render('petrutiu/login.html.twig');
    }

    #[Route('/petrutiu/edit', name: 'petrutiu_edit')]
    public function edit(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if (!$session->get('auth')) {
            return $this->redirectToRoute('petrutiu_login');
        }

        $content = $em->getRepository(PetrutiuContent::class)->findOneBy([]) ?? new PetrutiuContent();

        if ($request->isMethod('POST')) {
            $content->setTitlu($request->request->get('titlu'));
            $content->setDescriere($request->request->get('descriere'));
            $content->setHobbyuri($request->request->get('hobbyuri'));
            $content->setEducatie($request->request->get('educatie'));
            $content->setExperienta($request->request->get('experienta'));
            $em->persist($content);
            $em->flush();
            return $this->redirectToRoute('petrutiu_index');
        }

        return $this->render('petrutiu/edit.html.twig', [
            'content' => $content,
        ]);
    }
}
