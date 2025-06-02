<?php

namespace App\Controller;

use App\Entity\AkmaralSeyidovaAboutMe;
use App\Form\AkmaralSeyidovaAboutMeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AkmaralFormController extends AbstractController
{
    #[Route('/akmaral/form', name: 'akmaral_form')]
    public function form(Request $request, EntityManagerInterface $em): Response
    {
        $aboutMe = new AkmaralSeyidovaAboutMe();
        $form = $this->createForm(AkmaralSeyidovaAboutMeType::class, $aboutMe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($aboutMe);
            $em->flush();

            return $this->redirectToRoute('app_akmaral');
        }

        return $this->render('akmaral/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
