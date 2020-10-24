<?php

$curl = curl_init('https://api.nasa.gov/planetary/apod?api_key=uQ71al00jCuNnjNYTfeGvzsHKWBessjLq2h24HpO');
        curl_setopt_array($curl, [
            CURLOPT_CAINFO => __DIR__ . DIRECTORY_SEPARATOR . '../certif/cert.cer',
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $data = curl_exec($curl);
        if ($data === false) {
            var_dump(curl_error($curl));
        } else {
            $data = json_decode($data, true);
            echo '<pre>';
var_dump($data);
var_dump($data['title']);
            echo '</pre>';
        }
        curl_close($curl);