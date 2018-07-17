<?php

if (!isset($seg)) {
    exit;
}
$SendCadPg = filter_input(INPUT_POST, 'SendCadPg', FILTER_SANITIZE_STRING);
if ($SendCadPg) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    $dados_obs = $dados['obs'];
    unset($dados['obs']);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar a página!</div>";
    } else {
        //Proibir cadastro de página duplicado
        $result_paginas = "SELECT id FROM sts_paginas WHERE endereco='" . $dados_validos['endereco'] . "' AND sts_tps_pg_id='" . $dados_validos['sts_tps_pg_id'] . "'";
        $resultado_paginas = mysqli_query($conn, $result_paginas);
        if (($resultado_paginas) AND ( $resultado_paginas->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este endereço já está cadastrado!</div>";
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
        $dados['obs'] = trim($dados_obs);
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/sts_cad_pagina';
        header("Location: $url_destino");
    } else {
        //Pesquisar o maior número da ordem na tabela sts_paginas
        $result_maior_ordem = "SELECT ordem FROM sts_paginas ORDER BY ordem DESC LIMIT 1";
        $resultado_maior_ordem = mysqli_query($conn, $result_maior_ordem);
        $row_maior_ordem = mysqli_fetch_assoc($resultado_maior_ordem);
        $ordem = $row_maior_ordem['ordem'] + 1;
        
        $result_cad_pg = "INSERT INTO sts_paginas (endereco, nome_pagina, titulo, obs, keywords, description, author, $campo_foto lib_bloq, ordem, depend_pg, sts_tps_pg_id, sts_robot_id, sts_situacaos_pg_id, created) VALUES (
        '" . $dados_validos['endereco'] . "',
        '" . $dados_validos['nome_pagina'] . "',
        '" . $dados_validos['titulo'] . "',
        '$dados_obs',
        '" . $dados_validos['keywords'] . "',
        '" . $dados_validos['description'] . "',
        '" . $dados_validos['author'] . "',
        $valor_foto
        '" . $dados_validos['lib_bloq'] . "',
        '$ordem',
        '" . $dados_validos['depend_pg'] . "',
        '" . $dados_validos['sts_tps_pg_id'] . "',
        '" . $dados_validos['sts_robot_id'] . "',                
        '" . $dados_validos['sts_situacaos_pg_id'] . "',
        NOW())";
        
        mysqli_query($conn, $result_cad_pg);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);  
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';
                $destino = "../assets/imagens/paginas/" . mysqli_insert_id($conn) . "/";
                upload($foto, $destino, 1200, 627);
            }
            
            $_SESSION['msg'] = "<div class='alert alert-success'>Página cadastrada!</div>";
            $url_destino = pg . '/listar/sts_list_pagina';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Página não cadastrada!</div>";
            $url_destino = pg . '/cadastrar/sts_cad_pagina';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
