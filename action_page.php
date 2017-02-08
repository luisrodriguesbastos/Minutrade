<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

envia_form($_POST);
/**
 * Funcao que envia os dados de busca e cadastro
 * @param type $post
 */
function envia_form($post) {
    // var_dump($_POST);

    extract($_POST);

    //set POST variables
    $url = 'http://localhost/ProjetoMinutrade/api_page.php';
    $fields = $_POST;

    //url-ify the data for the POST
    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_POST => count($fields),
        CURLOPT_POSTFIELDS => $fields_string
    );
    curl_setopt_array($ch, $options);

    //execute post
    $result = curl_exec($ch);

    echo $result;

    //close connection
    curl_close($ch);
}
