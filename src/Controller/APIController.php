<?php

namespace App\Controller;

use App\Entity\ApiLink;
use App\Form\ApiLinkType;
use App\Repository\ArticleRepository;
use App\Utils\HateoasBuilderMMP;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class APIController
 * @package App\Controller
 */
class APIController extends AbstractController
{

    /**
     * @var HateoasBuilderMMP
     */
    private $hateoas;

    public function __construct(HateoasBuilderMMP $hateoasMmp)
    {
        $this->hateoas = $hateoasMmp->create();
    }

    /**
     * @param ArticleRepository $repository
     * @return Response
     */
    public function index(ArticleRepository $repository):  Response
    {
        $articles = $repository->getLatestArticles();
        $json = null;
        try {
            $json = $this->hateoas->serialize($articles,'json');
        } catch (ExceptionInterface $e) {
        }

        return new Response($json,200,[
            'content-type' => 'application/json'
        ]);
    }



    public function show(): Response
    {
        $articles = null;
        $apiLink = new ApiLink();
        $form = $this->createForm(ApiLinkType::class,$apiLink);
        //$form->handleRequest($request);

        return $this->render('api/index.html.twig',[
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }
}
