<?php
// src/Controller/IonutController.php
namespace App\Controller;

use App\Entity\IonutPageContent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class IonutController extends AbstractController
{
    #[Route('/ionut', name: 'ionut_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $content = $em->getRepository(IonutPageContent::class)->find(1);

        return $this->render('Ionut/Hero.html.twig', [
            'content' => $content,
        ]);
    }

    #[Route('/ionut/edit', name: 'ionut_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        try{
            // Cerem logarea cu utilizator și parolă si trimitem userul catre pagina de login daca nu este logat
            $session = $request->getSession();
            $role = $session->get('role');
            if ($role !== "ROLE_ADMIN") {
                return $this->redirectToRoute('ionut_login', ['returnUrl' => $request->getRequestUri()]);
            }
        } catch (\Exception $e) {
            return $this->redirectToRoute('ionut_login', ['returnUrl' => $request->getRequestUri()]);
        }


        // Obține conținutul din baza de date
        $content = $em->getRepository(IonutPageContent::class)->find(1);
        if (!$content) {
            $content = new IonutPageContent();
        }

        // Salvează modificările dacă formularul este trimis
        if ($request->isMethod('POST')) {
            $content->setTitle($request->request->get('title'));
            $content->setContent($request->request->get('content'));

            $em->persist($content);
            $em->flush();

            $this->addFlash('success', 'Conținutul a fost actualizat cu succes!');
            return $this->redirectToRoute('ionut_page');
        }

        return $this->render('Ionut/edit.html.twig', [
            'content' => $content,
        ]);
    }
 
    // Ruta de login cu Return URL
    #[Route('/ionut/login', name: 'ionut_login', methods: ['GET', 'POST'])]
    public function login(Request $request, EntityManagerInterface $em): Response
    {
        // Salvează URL-ul de returnare
        $returnUrl = $request->query->get('returnUrl');

        $session = $request->getSession();
        $session->set('returnUrl', $returnUrl);

        // Redirecteaza catre pagina de login dupa login cu succes
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        if ($username === 'admin' && $password === 'password123') {
            $session->set('role', "ROLE_ADMIN");
            $session->set('username', $username);

            // Redirecteaza catre URL-ul de returnare daca exista sau catre pagina principala

            if ($returnUrl) {
                return $this->redirect($returnUrl);
            }
            else {
                return $this->redirectToRoute('ionut_page');
            }
        }

        return $this->render('Ionut/login.html.twig', [
            'returnUrl' => $returnUrl,
        ]);
    }
}