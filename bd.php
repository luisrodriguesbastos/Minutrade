<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Conexao com o BD MySql
 * @return type
 */
function conecta_bd() {
    $link = mysqli_connect('localhost', 'root', '', 'minutrade');
    if (!$link) {
        die('Não foi possível conectar: ' . mysql_error());
    }
    return $link;
}
