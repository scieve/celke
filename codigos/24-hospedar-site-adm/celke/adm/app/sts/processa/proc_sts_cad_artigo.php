<?php

if (!isset($seg)) {
    exit;
}
$SendCadArt = filter_input(INPUT_POST, 'SendCadArt', FILTER_SANITIZE_STRING);
if ($SendCadArt) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    $dados_resumo_publico = $dados['resumo_publico'];
    unset($dados['resumo_publico']);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o artigo!</div>";
    } else {
        //Proibir cadastro de slug duplicado
        include_once 'lib/lib_caracter_esp.php';
        $dados_validos['slug'] = caracterEspecial($dados_validos['slug']);
        $result_artigo = "SELECT id FROM sts_artigos WHERE slug='" . $dados_validos['slug'] . "' ";
        $resultado_artigo = mysqli_query($conn, $result_artigo);
        if (($resultado_artigo) AND ( $resultado_artigo->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este endereço de slug já está cadastrado!</div>";
        }
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
        $dados['resumo_publico'] = trim($dados_resumo_publico);
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/sts_cad_artigo';
        header("Location: $url_destino");
    } else {

        $result_cad_pg = "INSERT INTO sts_artigos (titulo, descricao, conteudo, $campo_foto slug, keywords, description, author, resumo_publico, sts_robot_id, adms_usuario_id, sts_situacoe_id, sts_tps_artigo_id, sts_cats_artigo_id, created) VALUES (
        '" . $dados_validos['titulo'] . "',
        '" . $dados_validos['descricao'] . "',
        '" . $dados_validos['conteudo'] . "',
        $valor_foto
        '" . $dados_validos['slug'] . "',
        '" . $dados_validos['keywords'] . "',
        '" . $dados_validos['description'] . "',
        '" . $dados_validos['author'] . "',
        '$dados_resumo_publico',
        '" . $dados_validos['sts_robot_id'] . "',
        '" . $dados_validos['adms_usuario_id'] . "',
        '" . $dados_validos['sts_situacoe_id'] . "',                
        '" . $dados_validos['sts_tps_artigo_id'] . "',             
        '" . $dados_validos['sts_cats_artigo_id'] . "',
        NOW())";

        mysqli_query($conn, $result_cad_pg);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';
                $destino = "../assets/imagens/artigo/" . mysqli_insert_id($conn) . "/";
                upload($foto, $destino, 1200, 627);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>Artigo cadastrado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_artigo';
            header("Location: $url_destino");
        } else {
            $dados['resumo_publico'] = trim($dados_resumo_publico);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não cadastrado!</div>";
            $url_destino = pg . '/cadastrar/sts_cad_artigo';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
