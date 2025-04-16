<?php
namespace App\Controller;

use App\Entity\DraganPageContent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DraganController extends AbstractController
{
    #[Route('/Dragan/Hero', name: 'dragan_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $content = $em->getRepository(DraganPageContent::class)->find(1);

        return $this->render('Dragan/Hero.html.twig', [
            'content' => $content,
        ]);
    }

    #[Route('/Dragan/login', name: 'dragan_login', methods: ['POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        $user = "admin";
        $pass = "1234";

        $enteredUser = $request->request->get('user');
        $enteredPass = $request->request->get('password');

        if ($enteredUser === $user && $enteredPass === $pass) {
            $session->set('authenticated', true);
            return $this->redirectToRoute('dragan_edit');
        }

        return $this->redirectToRoute('dragan_page', ['error' => 'Invalid credentials']);
    }

    #[Route('/Dragan/edit', name: 'dragan_edit')]
    public function edit(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if (!$session->get('authenticated')) {
            return new Response("Acces interzis! Trebuie să te autentifici.", 403);
        }
		else{

        $content = $em->getRepository(DraganPageContent::class)->find(1);
        if (!$content) {
            $content = new DraganPageContent();
        }

        if ($request->isMethod('POST')) {
            $content->setTitle($request->request->get('title'));
            $content->setContent($request->request->get('content'));

            $em->persist($content);
            $em->flush();

            return $this->redirectToRoute('dragan_page');
        }

        return $this->render('dragan/edit.html.twig', [
            'content' => $content,
        ]);
		}
    }

    #[Route('/Dragan/logout', name: 'dragan_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->remove('authenticated');
        return $this->redirectToRoute('dragan_page');
    }
}
