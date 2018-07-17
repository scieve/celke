<?php

if (!isset($seg)) {
    exit;
}
$SendEditPg = filter_input(INPUT_POST, 'SendEditPg', FILTER_SANITIZE_STRING);
if ($SendEditPg) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    $dados_obs = $dados['obs'];
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['obs'], $dados['imagem_antiga']);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar a página!</div>";
    } else {
        //Proibir cadastro de página duplicado
        $result_paginas = "SELECT id FROM sts_paginas WHERE endereco='" . $dados_validos['endereco'] . "' AND sts_tps_pg_id='" . $dados_validos['sts_tps_pg_id'] . "' AND id<>'".$dados['id']."' ";
        $resultado_paginas = mysqli_query($conn, $result_paginas);
        if (($resultado_paginas) AND ( $resultado_paginas->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este endereço já está cadastrado!</div>";
        }
    }
    
    //Validar imagem
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
            $campo_foto = "imagem = ";
            $valor_foto = "'" . $foto['name'] . "',";
        }
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $dados['obs'] = trim($dados_obs);
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_pagina?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE sts_paginas SET
                endereco='" . $dados_validos['endereco'] . "', 
                nome_pagina='" . $dados_validos['nome_pagina'] . "', 
                titulo='" . $dados_validos['titulo'] . "', 
                obs='" . $dados_obs . "', 
                keywords='" . $dados_validos['keywords'] . "', 
                description='" . $dados_validos['description'] . "', 
                author='" . $dados_validos['author'] . "', 
                $campo_foto $valor_foto
                lib_bloq='" . $dados_validos['lib_bloq'] . "', 
                depend_pg='" . $dados_validos['depend_pg'] . "', 
                sts_tps_pg_id='" . $dados_validos['sts_tps_pg_id'] . "', 
                sts_robot_id='" . $dados_validos['sts_robot_id'] . "', 
                sts_situacaos_pg_id='" . $dados_validos['sts_situacaos_pg_id'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        
        mysqli_query($conn, $result_pg_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);    
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';                
                $destino = "../assets/imagens/paginas/" . $dados['id'] . "/";
                $destino_apagar = $destino.$dados_imagem_antiga;
                apagarFoto($destino_apagar);
                upload($foto, $destino, 1200, 627);
            }           
            $_SESSION['msg'] = "<div class='alert alert-success'>Página editada!</div>";
            $url_destino = pg . '/listar/sts_list_pagina';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Página não editada!</div>";
            $url_destino = pg . '/editar/sts_edit_pagina?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
