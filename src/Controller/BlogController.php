<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class BlogController extends AbstractController
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(ArticleRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $repository->getAllArticlesQuery(),
            $request->query->getInt("page",1),
            9
        );

        $role = null;
        $user = $this->security->getUser();
        if ($user !== null) {
            $role = $this->security->getUser()->getRoles()[0];
        }

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
            'user_role' => $role
        ]);
    }

    /**
     * @param Article $article
     * @param string $slug
     * @return Response
     * our article is directly recupereted by the ORM when the id is sent in the route
     */
    public function show(Article $article, string $slug): Response
    {
        // if user try to modify the slug directly from the url
        // 301 permenent redirecting (link update)
        $role = null;
        $user = $this->security->getUser();
        if ($user !== null) {
            $role = $this->security->getUser()->getRoles()[0];
        }

        if ($article->getSlug() !== $slug){
            return $this->redirectToRoute('article.index',[
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }

        return $this->render('Article/index.html.twig',[
            'article' => $article,
            'user_role' => $role
        ]);
    }
}
