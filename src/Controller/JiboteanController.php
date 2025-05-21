<?php

namespace App\Controller;

use App\Entity\JDVAdmin;
use App\Entity\JDVContent;
use App\Form\JDVContentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jibotean')]
class JiboteanController extends AbstractController
{

    #[Route('', name: 'JDV')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Încarcă conținutul din baza de date
        $content = $entityManager->getRepository(JDVContent::class)->findOneBy([]);
        
        // Verifică dacă utilizatorul este logat
        $session = $request->getSession();
        $isAuthenticated = $session->get('admin_authenticated', false);
        
        return $this->render('jibotean/index.html.twig', [
            'content' => $content,
            'is_authenticated' => $isAuthenticated,
        ]);
    }
    
    #[Route('/login', name: 'JDV_login')]
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();

        // Dacă utilizatorul e deja autentificat, redirecționează
        if ($session->get('admin_authenticated', false)) {
            return $this->redirectToRoute('JDV');
        }
        
        $error = null;
        
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            
            // Caută administratorul în baza de date
            $admin = $entityManager->getRepository(JDVAdmin::class)
                ->findOneBy(['username' => $username]);
            
            if ($admin && $admin->getPassword() === $password) {
                // Autentificare reușită
                $session->set('admin_authenticated', true);
                return $this->redirectToRoute('JDV');
            }
            
            $error = 'Nume de utilizator sau parolă incorecte.';
        }
        
        return $this->render('jibotean/login.html.twig', [
            'error' => $error,
        ]);
    }
    
    #[Route('/edit', name: 'JDV_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();

        // Verifică dacă utilizatorul este autentificat
        if (!$session->get('admin_authenticated', false)) {
            return $this->redirectToRoute('JDV_login');
        }
        
        // Încarcă conținutul din baza de date
        $content = $entityManager->getRepository(JDVContent::class)->findOneBy([]);
        
        if (!$content) {
            throw $this->createNotFoundException('Conținutul nu a fost găsit.');
        }
        
        // Creează formularul
        $form = $this->createForm(JDVContentType::class, $content);
        
        // Setează valoarea pentru câmpul skillsText
        $form->get('skillsText')->setData($content->getSkillsText());
        
        // Procesează formularul
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Procesează skills din text în array
            $skillsText = $form->get('skillsText')->getData();
            $skills = array_filter(array_map('trim', explode("\n", $skillsText)));
            $content->setSkills($skills);
            
            // Actualizează data modificării
            $content->setUpdatedAt(new \DateTimeImmutable());
            
            // Salvează modificările
            $entityManager->flush();
            
            $this->addFlash('success', 'Conținutul a fost actualizat cu succes.');
            
            return $this->redirectToRoute('JDV');
        }
        
        return $this->render('jibotean/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/logout', name: 'JDV_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('admin_authenticated');
        return $this->redirectToRoute('JDV');
    }
}
