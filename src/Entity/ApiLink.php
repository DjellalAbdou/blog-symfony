<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ApiLink
{
    /**
     * @var string|null
     * @Assert\Url()
     */
    private $URL;

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->URL;
    }

    /**
     * @param mixed $URL
     */
    public function setURL($URL): void
    {
        $this->URL = $URL;
    }
}