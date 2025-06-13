<?php
namespace App\Controller;

use App\Entity\JDVPageContent;
use App\Entity\JDVComp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jibotean')]
class JiboteanController extends AbstractController
{
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_PASSWORD = 'parola123';

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('', name: 'jdv_home')]
    public function index(): Response
    {
        try {
            $aboutContent = $this->getOrCreateAboutContent();
            $skills = $this->getOrCreateSkills();

            return $this->render('Jibotean/index.html.twig', [
                'aboutContent' => $aboutContent,
                'skills' => $skills,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Eroare în Controller:index: ' . $e->getMessage(), 0, $e);
        }
    }

    #[Route('/login', name: 'jdv_login')]
    public function login(Request $request, SessionInterface $session): Response
    {
        // Dacă utilizatorul este deja logat, redirecționează
        if ($session->get('is_admin_logged_in')) {
            return $this->redirectToRoute('jdv_home');
        }

        $error = null;

        // Procesează formularul de login
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            if ($username === self::ADMIN_USERNAME && $password === self::ADMIN_PASSWORD) {
                // Login reușit - salvează în sesiune
                $session->set('is_admin_logged_in', true);
                //$session->set('admin_username', $username);
                
                // Mesaj de succes
                //$this->addFlash('success', 'Te-ai logat cu succes!');
                
                return $this->redirectToRoute('jdv_home');
            } else {
                // Login eșuat
                $error = 'Username sau parolă incorectă!';
            }
        }

        return $this->render('Jibotean/login.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'jdv_logout')]
    public function logout(SessionInterface $session): Response
    {
        // Șterge sesiunea
        $session->remove('is_admin_logged_in');
        //$session->remove('admin_username');
        
        //$this->addFlash('success', 'Te-ai delogat cu succes!');
        
        return $this->redirectToRoute('jdv_home');
    }

    #[Route('/edit', name: 'jdv_edit')]
    public function edit(Request $request, SessionInterface $session): Response
    {
        // Verifică dacă utilizatorul este logat
        if (!$session->get('is_admin_logged_in')) {
            $this->addFlash('error', 'Trebuie să te loghezi pentru a accesa această pagină.');
            return $this->redirectToRoute('jdv_login');
        }

        try {
            $aboutContent = $this->getOrCreateAboutContent();
            $skills = $this->getOrCreateSkills();

            if ($request->isMethod('POST')) {
                $action = $request->request->get('action');

                switch ($action) {
                    case 'update_content':
                        $this->updateContent($request, $aboutContent);
                        break;
                    case 'add_skill':
                        $this->addSkill($request);
                        break;
                    case 'update_skills':
                        $this->updateSkills($request);
                        break;
                }

                return $this->redirectToRoute('jdv_edit');
            }

            return $this->render('Jibotean/edit.html.twig', [
                'aboutContent' => $aboutContent,
                'skills' => $skills,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Eroare în Controller:edit: ' . $e->getMessage(), 0, $e);
        }
    }

    #[Route('/skill/delete/{id}', name: 'jdv_delete_skill', methods: ['DELETE'])]
    public function deleteSkill(int $id, Request $request, SessionInterface $session): JsonResponse
    {
        // Verifică dacă utilizatorul este logat
        if (!$session->get('is_admin_logged_in')) {
            return new JsonResponse(['success' => false, 'message' => 'Nu ești autentificat!'], 401);
        }

        if ($request->isXmlHttpRequest()) {
            $skill = $this->entityManager->getRepository(\App\Entity\JDVComp::class)->find($id);
            
            if ($skill) {
                $this->entityManager->remove($skill);
                $this->entityManager->flush();
                
                return new JsonResponse(['success' => true]);
            }
        }
        
        return new JsonResponse(['success' => false], 400);
    }

    // === Metode Private ===
    
    private function getOrCreateAboutContent(): JDVPageContent
    {
        try {
            $contentRepo = $this->entityManager->getRepository(JDVPageContent::class);
            $aboutContent = $contentRepo->findOneBy([]);
            
            if (!$aboutContent) {
                $aboutContent = new JDVPageContent();
                $aboutContent->setContent("Sunt un dezvoltator web cu experiență în domeniul tehnologiilor moderne și al dezvoltării aplicațiilor web scalabile. Activitatea mea profesională se concentrează pe implementarea soluțiilor tehnice eficiente și pe optimizarea performanțelor sistemelor informatice. În cadrul proiectelor pe care le dezvolt, pun accent pe calitatea codului și pe respectarea standardelor industriei. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Esse illo iusto, magnam et, soluta hic expedita sit possimus ipsum facere laboriosam. Quia laboriosam explicabo debitis ut, nam possimus modi optio!\n\nLorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae esse voluptates praesentium sunt, culpa deleniti, atque ab dolores molestias magni perspiciatis quibusdam quaerat. Laboriosam expedita esse corporis maiores eveniet error. Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit ipsam reprehenderit eos omnis animi dolorem? Qui, illum fugiat recusandae quidem at sunt aperiam eaque, cumque, animi suscipit reiciendis optio sapiente.");
                
                $this->entityManager->persist($aboutContent);
                $this->entityManager->flush();
            }
            
            return $aboutContent;
        } catch (\Exception $e) {
            throw new \Exception('Eroare la crearea conținutului despre: ' . $e->getMessage(), 0, $e);
        }
    }

    private function getOrCreateSkills(): array
    {
        try {
            $skillRepo = $this->entityManager->getRepository(\App\Entity\JDVComp::class);
            $skills = $skillRepo->findBy([]);
            
            if (empty($skills)) {
                $skillsData = [
                    'PHP & Symfony Framework',
                    'JavaScript ES6+ & TypeScript',
                    'React.js & Vue.js',
                    'MySQL & PostgreSQL',
                    'Docker & Containerization',
                    'Git & Version Control',
                    'AWS & Cloud Services',
                    'RESTful APIs & GraphQL',
                ];

                foreach ($skillsData as $skillName) {
                    $skill = new \App\Entity\JDVComp();
                    $skill->setName($skillName);
                    
                    $this->entityManager->persist($skill);
                    $skills[] = $skill;
                }
                
                $this->entityManager->flush();
            }
            
            return $skills;
        } catch (\Exception $e) {
            throw new \Exception('Eroare la crearea competențelor: ' . $e->getMessage(), 0, $e);
        }
    }

    private function updateContent(Request $request, JDVPageContent $aboutContent): void
    {
        $newContent = $request->request->get('about_content');
        
        if ($newContent !== null) {
            $aboutContent->setContent($newContent);
            $this->entityManager->persist($aboutContent);
            $this->entityManager->flush();

            $this->addFlash('success', 'Conținutul "Despre Mine" a fost actualizat cu succes!');
        }
    }

    private function addSkill(Request $request): void
    {
        $skillName = $request->request->get('new_skill');
        
        if ($skillName && trim($skillName) !== '') {
            //$skillRepo = $this->entityManager->getRepository(\App\Entity\JDVComp::class);
            
            $skill = new \App\Entity\JDVComp();
            $skill->setName(trim($skillName));
            
            $this->entityManager->persist($skill);
            $this->entityManager->flush();

            $this->addFlash('success', 'Competența "' . $skillName . '" a fost adăugată cu succes!');
        }
    }

    private function updateSkills(Request $request): void
    {
        $skillUpdates = $request->request->all('skills');
        
        foreach ($skillUpdates as $skillId => $skillName) {
            if (is_numeric($skillId) && trim($skillName) !== '') {
                $skill = $this->entityManager->getRepository(\App\Entity\JDVComp::class)->find($skillId);
                if ($skill && $skill->getName() !== trim($skillName)) {
                    $skill->setName(trim($skillName));
                }
            }
        }
        
        $this->entityManager->flush();
        $this->addFlash('success', 'Competențele au fost actualizate cu succes!');
    }
}
