<?php

namespace App\Controller;

use App\Entity\HighlanderBlogAccount;
use App\Entity\HighlanderBlogArticle;
use App\Entity\HighlanderBlogComment;
use App\Form\HighlanderBlogAccountType;
use App\Entity\HighlanderBlogLogin;
use App\Form\HighlanderBlogCreateArticleType;
use App\Form\HighlanderBlogAddCommentType;
use App\Form\HighlanderBlogLoginType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;

date_default_timezone_set('Europe/Bucharest');

class HighlanderController extends AbstractController
{
    
	#[Route(path: 'highlander/hero', name: 'highlander_hero_page')]
    public function hero(): Response
    {
        return $this->render('highlander/hero.html.twig');
    }

    #[Route('/highlander', name: 'highlander_redirect')]
    public function highlanderRedirect(): Response
    {
        return $this->redirectToRoute('blog_login_page');
    }


    #[Route('/highlander/logout', name: 'blog_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();

        return $this->redirectToRoute('blog_main_page');
    }


    #[Route(path: 'highlander/login', name: 'blog_login_page')]
    public function submitLogin(Request $request, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $isLogged = $session->get('isLogged', false);

        if($isLogged){
            return $this->redirectToRoute('blog_main_page');
        }

        $user = new HighlanderBlogLogin();
        $form = $this->createForm(HighlanderBlogLoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('username')->getData();
            $plainPassword = $form->get('password')->getData();
            $repo = $em->getRepository(HighlanderBlogAccount::class);
            $fetchedUser = $repo->findOneBy(['account_username' => $username]);

            if($fetchedUser != null){
                if(!password_verify($plainPassword, $fetchedUser->getAccountPassword())){
                    $form->get('username')->addError(new FormError('Wrong credentials!'));
                }
                else{
                    $session->set('user', $fetchedUser);
                    return $this->redirectToRoute('blog_main_page');
                }
            }
            else{
                $form->get('username')->addError(new FormError('Wrong credentials!'));
            }
        }

        return $this->render('highlander/login.html.twig', parameters: ['form' => $form->createView()]);
    }


    #[Route(path: 'highlander/register', name: 'blog_register_page')]
    public function register(Request $request, EntityManagerInterface $em): Response
    {
        $user = new HighlanderBlogAccount();

        $form = $this->createForm(HighlanderBlogAccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $register = true;

            $username = $form->get('account_username')->getData();
            $email = $form->get('account_email')->getData();
            $plainPassword = $form->get('account_password')->getData();
            $repassword = $form->get('account_repassword')->getData();

            $repo = $em->getRepository(HighlanderBlogAccount::class);
        
            if ($plainPassword !== $repassword) {
                $form->get('account_repassword')->addError(new FormError('Passwords do not match!'));
                $register = false;
            }
            
            if ($register && $repo->findOneBy(['account_username' => $username])) {
                $form->get('account_username')->addError(new FormError('Username is already taken!'));
                $register = false;
            }

            if($register && $repo->findOneBy(['account_email' => $email])){
                $form->get('account_email')->addError(new FormError('Email already in use!'));
                $register = false;
            }

            if($register){
                $hashedPassword = password_hash($user->getAccountPassword(), PASSWORD_BCRYPT);
                $user->setAccountUsername($username);
                $user->setAccountPassword($hashedPassword);
                $user->setAccountEmail($email);

                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Account created successfully!'
                );

                return $this->redirectToRoute('blog_login_page');
            }
        }

        return $this->render('highlander/register.html.twig', parameters: ['form' => $form->createView()]);
    }



    #[Route(path: 'highlander/index', name: 'blog_main_page')]
    public function indexPage(Request $request, EntityManagerInterface $em): Response{
        $session = $request->getSession();
        $form = $this->createForm(HighlanderBlogAddCommentType::class, );
        $form->handleRequest($request);
        $user = $session->get('user', null);
        $articles = $em->getRepository(HighlanderBlogArticle::class)->getAllArticles();
        $commentForms = [];

        foreach ($articles as $article) {
            $comment = new HighlanderBlogComment();
            $comment->setHighlanderBlogArticle($article);
            $comment->setHighlanderBlogAccount($user);
        
            $form = $this->createForm(HighlanderBlogAddCommentType::class, $comment, [
                'action' => $this->generateUrl('post_comment', ['id' => $article->getArticleId()])
            ]);
        
            $commentForms[$article->getArticleId()] = $form->createView();
        }

        return $this->render('highlander/index.html.twig', ['user' => $user, 'articles' => $articles, 'commentForms' => $commentForms]);
    }


    #[Route(path:'highlander/article/create_article', name: 'blog_create_article')]
    public function createArticlePage(Request $request, EntityManagerInterface $em): Response{
        $session = $request->getSession();
        $isLogged = $session->get('isLogged', false);

        if($isLogged){
            $user = $session->get('user', null);
            $article = new HighlanderBlogArticle();

            $form = $this->createForm(HighlanderBlogCreateArticleType::class, $article);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $title = $form->get('article_title')->getData();
                $content = $form->get('article_content')->getData();
                $userReference = $em->find('App\Entity\HighlanderBlogAccount', $user->getAccountId());
                $article->setArticleTitle($title);
                $article->setArticleContent($content);
                $article->setArticleDate(date("Y-m-d H:i:s"));
                $article->setHighlanderBlogAccount($userReference);

                $em->persist($article);
                $em->flush();

                return $this->redirectToRoute('blog_main_page');
            }
            
            return $this->render('highlander/createArticle.html.twig', ['user' => $user, 'form' => $form]);
        }
        else{
            $this->addFlash(
                'error',
                'YOU ARE NOT LOGGED IN!'
            );
            return $this->redirectToRoute('blog_login_page');
        }
    }


    #[Route('highlander/article/delete/{articleId}', name: 'blog_delete_article', methods: ['POST'])]
    public function deleteArticle(string $articleId, EntityManagerInterface $em, Request $request): Response
    {
        $article = $em->getRepository(HighlanderBlogArticle::class)->find($articleId);

        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        if ($this->isCsrfTokenValid('delete' . $articleId, $request->request->get('_token'))) {
            $em->remove($article);
            $em->flush();
        }
        return $this->redirectToRoute('blog_main_page');
    }


    #[Route('highlander/comment/delete/{commentId}', name: 'blog_delete_comment', methods: ['POST'])]
    public function deleteComment(string $commentId, EntityManagerInterface $em, Request $request): Response
    {
        $comment = $em->getRepository(HighlanderBlogComment::class)->find($commentId);

        if (!$comment) {
            throw $this->createNotFoundException('Comment not found');
        }

        if ($this->isCsrfTokenValid('delete' . $commentId, $request->request->get('_token'))) {
            $em->remove($comment);
            $em->flush();
        }
        return $this->redirectToRoute('blog_main_page');
    }


    #[Route(path: 'highlander/comment/{id}', name:'post_comment', methods: ['POST'])]
    public function postComment(Request $request, HighlanderBlogArticle $article, EntityManagerInterface $em): Response
    {
        $comment = new HighlanderBlogComment();
        $comment->setHighlanderBlogArticle($article);
        $user = $request->getSession()->get('user', null);
        if($user != null){
            $userReference = $em->find('App\Entity\HighlanderBlogAccount', $user->getAccountId());
        }
        else{
            $userReference = null;
        }
        $comment->setHighlanderBlogAccount($userReference);

        $form = $this->createForm(HighlanderBlogAddCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'html' => $this->renderView('highlander/partials/_comment.html.twig', [
                        'comment' => $comment
                    ])
                ]);
            }
        }

        return $this->redirectToRoute('blog_main_page');
    }
}