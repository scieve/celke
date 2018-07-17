<?php

if (!isset($seg)) {
    exit;
}
$SendCadPergResp = filter_input(INPUT_POST, 'SendCadPergResp', FILTER_SANITIZE_STRING);
if ($SendCadPergResp) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar a pergunta e resposta!</div>";
    } 
    
    //Criar as variaveis da foto quando a mesma não está sendo cadastrada
    if (empty($_FILES['imagem']['name'])) {
        $campo_foto = "";
        $valor_foto = "";
    }
    //validar extensão da imagem
    else {
        $foto = $_FILES['imagem'];
        include_once 'lib/lib_val_img_ext.php';
        if (!validarExtensao($foto['type'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Extensão da foto inválida!</div>";
        } else {
            include_once 'lib/lib_caracter_esp.php';
            $foto['name'] = caracterEspecial($foto['name']);
            $campo_foto = "imagem,";
            $valor_foto = "'" . $foto['name'] . "',";
        }
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $dados['obs'] = trim($dados_obs);
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/sts_cad_perg_resp';
        header("Location: $url_destino");
    } else {
        //Pesquisar o maior número da ordem na tabela sts_paginas
        $result_maior_ordem = "SELECT ordem FROM sts_pergs_resps ORDER BY ordem DESC LIMIT 1";
        $resultado_maior_ordem = mysqli_query($conn, $result_maior_ordem);
        $row_maior_ordem = mysqli_fetch_assoc($resultado_maior_ordem);
        $ordem = $row_maior_ordem['ordem'] + 1;
        
        $result_cad_perg_resp = "INSERT INTO sts_pergs_resps (pergunta, resposta, ordem, sts_situacoe_id, created) VALUES (
        '" . $dados_validos['pergunta'] . "',
        '" . $dados_validos['resposta'] . "',
        '$ordem',
        '" . $dados_validos['sts_situacoe_id'] . "',
        NOW())";
        
        mysqli_query($conn, $result_cad_perg_resp);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);            
            $_SESSION['msg'] = "<div class='alert alert-success'>Pergunta e resposta cadastrada com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_perg_resp';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Pergunta e resposta não foi cadastrado!</div>";
            $url_destino = pg . '/cadastrar/sts_cad_perg_resp';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
