<?php

namespace App\Model;

use DateTime;

class Comment
{
    private $id;
    private $postNumber;
    private $content;
    private $creationDate;
    private $updateDate;


    public function getId() : ?int //a utilisre dans la vue
    {
        return $this->id;
    }

    public function setId(?int $id) : self //int ou nul
    {
        $this->id = $id;

        return $this;
    }

    public function getPostNumber() : ?int //a utiliser dans la vue
    {
        return $this->postNumber;
    }

    public function setPostNumber(?int $postNumber) : self //int ou nul
    {
        $this->postNumber = $postNumber;

        return $this;
    }

    public function getContent() : ?string //a utiliser dans la vue
    {
        return $this->content;
    }

    public function setContent(?string $content) : self //int ou nul
    {
        $this->content = $content;

        return $this;
    }
    public function getCreationDate() : ?DateTime //a utiliser dans la vue
    {
        return $this->creationDate;
    }

    public function setCreationDate(?DateTime $creationDate)// : self //int ou nul
    {
        $this->creationDate = $creationDate;

        return $this;
    }
    public function getUpdateDate() : ?DateTime //a utiliser dans la vue
    {
        return $this->updateDate;
    }

    public function setupdateDate(?DateTime $updateDate)// : self //int ou nul
    {
        $this->updateDate = $updateDate;

        return $this;
    }
}