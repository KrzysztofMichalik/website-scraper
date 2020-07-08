<?php

function connection(string $url) : string
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    try {        
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } catch (Exception $e){
        return $e->getMessage();
    }
}
