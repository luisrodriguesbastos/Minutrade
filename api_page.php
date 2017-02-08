<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'bd.php';

$error = array();
$fone = array();
foreach ($_POST as $key => $value) {
    if (!isset($value) || $value == '' || $value === "0") {
        $error['erro'] = 'Preencha todos os dados';
        $error['cod'] = 1;
    }
    if ($key == 'cpf') {
        if (!valida_cpf($value)) {
            $error['erro'] = 'CPF invalido';
            $error['cod'] = 2;
        }
    }
    $isTel = array();
    preg_match('/fone/', $key, $isTel);
    if (count($isTel) == 1) {
        $fone[] = $value;
    }
}
if (count($error) != 0) {
    echo json_encode($error);
} else {
    if ($_POST['type'] == 'cadastro') {
        if (!busca_usuario($_POST['cpf'])) {
            insere_usuario($_POST, $fone);
        }else{
            echo 'Esse usuario ja existe';
            die;
        }
    } else {
        $dados = busca_usuario($_POST['cpf']);
        if (!$dados) {
            $dados = 'Nenhum resultado';
        }
        echo json_encode($dados);
        die;
    }
}

/**
 * Funcao que insere os dados do usuario
 * @param type $dados
 * @param type $fone
 */
function insere_usuario($dados, $fone) {
    $link = conecta_bd();
    $sql = "INSERT INTO cliente (name,cpf,email,marital_status) VALUES ";
    $sql .= "('" . $dados['name'] . "', '" . $dados['cpf'] . "', '" . $dados['email'] . "','" . $dados['marital_status'] . "')";
    mysqli_query($link, $sql) or die("Erro ao tentar cadastrar registro");
    $clientId = mysqli_insert_id($link);
    foreach ($fone as $number) {
        $sqlFone = "INSERT INTO telefone (cliente_id, number) VALUES ('" . $clientId . "', '" . $number . "')";
        mysqli_query($link, $sqlFone) or die("Erro ao tentar cadastrar registro");
    }
    mysqli_close($link);

    echo 'Usuari inserido';
    die;
}

/**
 * Funcao que retorna a busca do usuario
 * @param type $cpf
 * @return type
 */
function busca_usuario($cpf) {
    $link = conecta_bd();
    $sql = "SELECT * FROM cliente WHERE cpf = '" . $cpf . "'";
    $result = mysqli_query($link, $sql);
    if ($row = mysqli_fetch_array($result)) {
        mysqli_close($link);
        return $row;
    }
}

/**
 * Funcao para validacao do CPF
 * @param type $cpf
 * @return boolean
 */
function valida_cpf($cpf) {
    $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
        return FALSE;
    } else { // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return FALSE;
            }
        }
        return TRUE;
    }
}
