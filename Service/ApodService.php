<?php

namespace App\Service;

use App\Model\PostManager;

class ApodService
{
    public function __construct()
    {
        $this->create();
    }

    public function getData()
    {
        $curl = curl_init('https://api.nasa.gov/planetary/apod?api_key=uQ71al00jCuNnjNYTfeGvzsHKWBessjLq2h24HpO');
        curl_setopt_array($curl, [
            CURLOPT_CAINFO => __DIR__ . DIRECTORY_SEPARATOR . '../certif/cert.cer',
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $data = curl_exec($curl);
        if ($data === false) { } else {
            $data = json_decode($data, true);
        }
        curl_close($curl);

        return $data;
    }

    public function create()
    {
        $postManager = new PostManager();
        $postManager->create($this->getData());
    }
}
