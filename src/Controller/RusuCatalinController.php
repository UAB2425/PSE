<?php

namespace App\Controller;

use App\Entity\RusuCatalinPageContent;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class RusuCatalinController extends AbstractController
{
    #[Route('/Rusu', name: 'Rusu')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(RusuCatalinPageContent::class);
        $page = $repository->find(1);

        $em = $doctrine->getManager();

        if (!$page) {
            $page = new RusuCatalinPageContent();
            $page->setTitle('Rusu Cătălin');
            $page->setContent('
                <p>Sunt un pasionat de tehnologie și programare, cu experiență în dezvoltarea web.</p>
                <p>Îmi place să explorez noi tehnologii și să construiesc aplicații eficiente și scalabile.</p>
                <p>În timpul liber, îmi place să citesc, să călătoresc și să experimentez cu proiecte open-source.</p>
                <h2>Interese:</h2>
                <ul>
                    <li>Programare web</li>
                    <li>Inteligență artificială</li>
                    <li>Proiecte open-source</li>
                </ul>
            ');
            $em->persist($page);
            $em->flush();
        } elseif (empty($page->getContent())) {
            $page->setContent('
                <p>Sunt un pasionat de tehnologie și programare, cu experiență în dezvoltarea web.</p>
                <p>Îmi place să explorez noi tehnologii și să construiesc aplicații eficiente și scalabile.</p>
                <p>În timpul liber, îmi place să citesc, să călătoresc și să experimentez cu proiecte open-source.</p>
                <h2>Interese:</h2>
                <ul>
                    <li>Programare web</li>
                    <li>Inteligență artificială</li>
                    <li>Proiecte open-source</li>
                </ul>
            ');
            $em->flush();
        }

        return $this->render('Rusu/index.html.twig', [
            'name' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }
    #[Route('/Rusu/edit', name: 'Rusu_edit')]
    public function edit(
        ManagerRegistry $doctrine,
        Request $request,
        SessionInterface $session
    ): Response {
        // Autentificare simplă
        $username = 'admin';
        $password = 'parola123';
    
        $inputUser = $request->query->get('user');
        $inputPass = $request->query->get('pass');
    
        if ($session->get('logged_in') !== true) {
            if ($inputUser === $username && $inputPass === $password) {
                $session->set('logged_in', true);
            } else {
                return new Response('<h2>Acces restricționat</h2><p>Adaugă <code>?user=admin&pass=parola123</code> în URL.</p>');
            }
        }
    
        $em = $doctrine->getManager();
        $repository = $em->getRepository(RusuCatalinPageContent::class);
        $page = $repository->find(1);
    
        if (!$page) {
            $page = new RusuCatalinPageContent();
            $page->setTitle('Rusu Cătălin');
        }
    
        if ($request->isMethod('POST')) {
            $newContent = $request->request->get('content');
            $page->setContent($newContent);
            $em->persist($page);
            $em->flush();
    
            return new RedirectResponse($this->generateUrl('Rusu'));
        }
    
        return $this->render('Rusu/edit.html.twig', [
            'page' => $page
        ]);
    }
    

}