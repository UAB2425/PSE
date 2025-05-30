<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;

    class AchimescuAndreiController extends AbstractController
    {
        #[Route('/achimescu-andrei', name: 'achimescu-andrei')]
        public function index_page(): Response
        {
            return $this->render("Achimescu/Achimescu.html.twig");
        }
    }

?>