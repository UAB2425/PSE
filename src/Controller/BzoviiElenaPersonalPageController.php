<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BzoviiElenaPersonalPageController extends AbstractController
{
    #[Route('/Bzovii/Elena', name: 'bzovii_elena')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $content = $em->getRepository(\App\Entity\BzoviiElenadynamic::class)->find(1);

        if (!$content) {
            $content = new \App\Entity\BzoviiElenadynamic();
            $content->setNume('Bzovii Elena');
            $content->setDescriere('Descrierea despre Elena...');
        }

        return $this->render('bzoviielena.html.twig', [
            'content' => $content,
            'error' => $request->query->get('error'),
        ]);
    }

    #[Route('/Bzovii/Elena/login', name: 'bzovii_elena_login', methods: ['POST'])]
    public function login(Request $request, SessionInterface $session): Response
    {
        $user = "admin";
        $pass = "1234";

        $enteredUser = $request->request->get('username');
        $enteredPass = $request->request->get('password');

        if ($enteredUser === $user && $enteredPass === $pass) {
            $session->set('authenticated', true);
            return $this->redirectToRoute('bzovii_elena_edit');
        }

        return $this->redirectToRoute('bzovii_elena', ['error' => 'Invalid credentials']);
    }

    #[Route('/Bzovii/Elena/edit', name: 'bzovii_elena_edit')]
    public function edit(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if (!$session->get('authenticated')) {
            return new Response("Acces interzis! Trebuie să te autentifici.", 403);
        }
        else{

        $content = $em->getRepository(\App\Entity\BzoviiElenadynamic::class)->find(1);

        if (!$content) {
            $content = new \App\Entity\BzoviiElenadynamic();
        }

        if ($request->isMethod('POST')) {
            $content->setNume($request->request->get('nume'));
            $content->setDescriere($request->request->get('descriere'));

            $em->persist($content);
            $em->flush();

            return $this->redirectToRoute('bzovii_elena');
        }

        return $this->render('edit_bzovii_elena.html.twig', [
            'content' => $content,
        ]);
    }
}

    #[Route('/Bzovii/Elena/logout', name: 'bzovii_elena_logout', methods: ['POST'])]
    public function logout(SessionInterface $session): Response
    {
        $session->remove('authenticated');
        return $this->redirectToRoute('bzovii_elena');
    }
}

