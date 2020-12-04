<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;


class AdminArticleController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param ArticleRepository $repository
     * @return Response
     */
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->getAllArticles();
        $role = null;
        $user = $this->security->getUser();
        if ($user !== null) {
            $role = $this->security->getUser()->getRoles()[0];
        }
        return $this->render('Admin/Article/index.html.twig', [
            'articles' => $articles,
            'user_role' => $role
        ]);
    }

    /**
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request): Response
    {
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article->setSlug();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('Admin/Article/edit.html.twig',[
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function delete(Article $article, Request $request): Response
    {
       if ($this->isCsrfTokenValid("delete".$article->getId(),$request->get("_token"))){
           $manager = $this->getDoctrine()->getManager();
           $manager->remove($article);
           $manager->flush();
       }
       return $this->redirectToRoute("admin.article.index");
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article->setSlug();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute("admin.article.index");
        }

        return $this->render("Admin/Article/create.html.twig",[
            "article" => $article,
            "form" => $form->createView()
        ]);
    }

   }
