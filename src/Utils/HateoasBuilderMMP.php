<?php


namespace App\Utils;


use Hateoas\HateoasBuilder;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class HateoasBuilderMMP
{

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

/*    public static function getInstance(){
        if (self::$instance === null){
            self::$instance = (new HateoasBuilderMMP(self::$router))->create();
        }
        return self::$instance;
    }*/

    public function create()
    {
        return HateoasBuilder::create()
            ->setUrlGenerator(
                null,
                new SymfonyUrlGenerator($this->router)
            )
            ->build();
    }
}