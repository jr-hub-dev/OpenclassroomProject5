<?php

namespace App\Model;

use DateTime;

class Post
{
    private $id;
    private $title;
    private $creationDate;
    private $url;
    private $explanation;

   
    private $apiKey;

    // public function __construct(string $apiKey)
    // {
    //     $this->apiKey = $apiKey;
    // }


    public function getId(): ?int //a utiliser dans la vue
    {
        return $this->id;
    }

    public function setId(?int $id): self //int ou nul
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string //a utiliser dans la vue
    {
        return $this->title;
    }


    public function setTitle(?string $title): self //string ou nul
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string //url de l'image (content du post)
    {
        return $this->url;
    }

    public function setUrl(?string $url) // : self //int ou nul
    {
        $this->url = $url;

        return $this;
    }
    public function getExplanation(): ?string 
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation) // : self //int ou nul
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getCreationDate(): ?DateTime //a utiliser dans la vue
    {
        return $this->creationDate;
    }

    public function setCreationDate(?DateTime $creationDate) // : self //int ou nul
    {
        $this->creationDate = $creationDate;

        return $this;
    }
}
