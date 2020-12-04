<?php

namespace App\Controller;

use App\Entity\ApiLink;
use App\Form\ApiLinkType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIController extends AbstractController
{
    /**
     * @param ArticleRepository $repository
     * @param NormalizerInterface $normalizer
     * @return Response
     */
    public function index(ArticleRepository $repository, NormalizerInterface $normalizer): Response
    {
        $articles = $repository->getLatestArticles();
        $json = null;
        try {
            $normalized = $normalizer->normalize($articles);
            $json = json_encode($normalized);
        } catch (ExceptionInterface $e) {
        }

        return new Response($json,200,[
            'content-type' => 'application/json'
        ]);
    }

    /**
     * @param Request $request
     * @param HttpClientInterface $client
     * @return Response
     */
    public function show(Request $request, HttpClientInterface $client):Response
    {
        $articles = null;
        $apiLink = new ApiLink();
        $form = $this->createForm(ApiLinkType::class,$apiLink);
        $form->handleRequest($request);

        try {
        if ($form->isSubmitted() && $form->isValid()){
            //die($apiLink->getURL());
            $respApi = $client->request("GET",$apiLink->getURL());
            $statusCode = $respApi->getStatusCode();
            dump($respApi);
            if ($statusCode == 200){
                //$content = $respApi->getContent();
                return $this->redirectToRoute("blog");
            }

        }
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }

        return $this->render('api/index.html.twig',[
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }
}
