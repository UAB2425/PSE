<?php

namespace App\Controller;

use App\Entity\PopaDianaPageContent;
use App\Repository\PopaDianaPageContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PopaDianaController extends AbstractController
{
  	#[Route('/pagina-personala', name: 'pagina_personala')]
	public function index(PopaDianaPageContentRepository $repository): Response
	{
   	 	$continut = [];
    		foreach ($repository->findAll() as $item) {
        		$continut[$item->getSectiune()] = $item;
   		 }

    		return $this->render('popa_diana/index.html.twig', [
        	'continut' => $continut,
    		]);
	}

    	// Pagina de login (user/parolă hardcoded)
    	#[Route('/login', name: 'app_login')]
    	public function login(Request $request, SessionInterface $session): Response
    	{
        	$error = null;
        	if ($request->isMethod('POST')) {
            	$username = $request->request->get('username');
            	$password = $request->request->get('password');

            	// aici pui user și parolă fixă
            	if ($username === 'admin' && $password === 'parola123') {
                	$session->set('user', $username);
                	return $this->redirectToRoute('pagina_personala');
            	} else {
                	$error = 'User sau parolă incorectă.';
            	}
        	}

        	return $this->render('popa_diana/login.html.twig', [
            'error' => $error,
        	]);
    	}

    	// Logout - șterge sesiunea
    	#[Route('/logout', name: 'app_logout')]
    	public function logout(SessionInterface $session): Response
    	{
        	$session->remove('user');
        	return $this->redirectToRoute('pagina_personala');
    	}

#[Route('/pagina-personala/edit/{sectiune}', name: 'pagina_personala_edit')]
    public function edit(string $sectiune, Request $request, EntityManagerInterface $em, PopaDianaPageContentRepository $repository ): Response {
        // 1. Verifică autentificarea
      if (!$request->getSession()->get('user')) {
    return $this->redirectToRoute('app_login');
}

        // 2. Găsește conținutul după secțiune
        $continut = $repository->findOneBy(['sectiune' => $sectiune]);
        if (!$continut) {
            throw $this->createNotFoundException('Secțiunea nu există.');
        }

        // 3. Preia date din request (form submission)
        if ($request->isMethod('POST')) {
            $titlu = $request->request->get('titlu');
            $continutText = $request->request->get('continut');

            // Update entitatea
            $continut->setTitlu($titlu);
            $continut->setContinut($continutText);

            $em->persist($continut);
            $em->flush();

            $this->addFlash('success', 'Conținut actualizat cu succes!');

            return $this->redirectToRoute('pagina_personala');
        }

        // 4. Afișează formularul de editare
        return $this->render('popa_diana/edit.html.twig', [
            'sectiune' => $sectiune,
            'continut' => $continut,
        ]);
    }
}
