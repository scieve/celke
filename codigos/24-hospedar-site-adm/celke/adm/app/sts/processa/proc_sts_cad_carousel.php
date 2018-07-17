<?php

if (!isset($seg)) {
    exit;
}
$SendCadCar = filter_input(INPUT_POST, 'SendCadCar', FILTER_SANITIZE_STRING);
if ($SendCadCar) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o carousel!</div>";
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
        $url_destino = pg . '/cadastrar/sts_cad_carousel';
        header("Location: $url_destino");
    } else {
        //Pesquisar o maior número da ordem na tabela sts_paginas
        $result_maior_ordem = "SELECT ordem FROM sts_carousels ORDER BY ordem DESC LIMIT 1";
        $resultado_maior_ordem = mysqli_query($conn, $result_maior_ordem);
        $row_maior_ordem = mysqli_fetch_assoc($resultado_maior_ordem);
        $ordem = $row_maior_ordem['ordem'] + 1;
        
        $result_cad_car = "INSERT INTO sts_carousels (nome, $campo_foto titulo, descricao, posicao_text, titulo_botao, link, ordem, sts_cor_id, sts_situacoe_id, created) VALUES (
        '" . $dados_validos['nome'] . "',
        $valor_foto
        '" . $dados_validos['titulo'] . "',
        '" . $dados_validos['descricao'] . "',
        '" . $dados_validos['posicao_text'] . "',
        '" . $dados_validos['titulo_botao'] . "',
        '" . $dados_validos['link'] . "',
        '$ordem',
        '" . $dados_validos['sts_cor_id'] . "',
        '" . $dados_validos['sts_situacoe_id'] . "',
        NOW())";
        
        mysqli_query($conn, $result_cad_car);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);  
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';
                $destino = "../assets/imagens/carousel/" . mysqli_insert_id($conn) . "/";
                upload($foto, $destino, 1920, 848);
            }
            
            $_SESSION['msg'] = "<div class='alert alert-success'>Carousel cadastrada com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_carousel';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Carousel não foi cadastrado!</div>";
            $url_destino = pg . '/cadastrar/sts_cad_carousel';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
