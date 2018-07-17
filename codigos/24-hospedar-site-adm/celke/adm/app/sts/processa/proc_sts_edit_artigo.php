<?php

if (!isset($seg)) {
    exit;
}
$SendEditArt = filter_input(INPUT_POST, 'SendEditArt', FILTER_SANITIZE_STRING);
if ($SendEditArt) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    $dados_resumo_publico = $dados['resumo_publico'];
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['resumo_publico'], $dados['imagem_antiga']);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar o artigo!</div>";
    } else {
        //Proibir cadastro de página duplicado
        include_once 'lib/lib_caracter_esp.php';
        $dados_validos['slug'] = caracterEspecial($dados_validos['slug']);
        $result_artigo = "SELECT id FROM sts_artigos WHERE slug='" . $dados_validos['slug'] . "' AND id<>'".$dados['id']."' ";
        $resultado_artigo = mysqli_query($conn, $result_artigo);
        if (($resultado_artigo) AND ( $resultado_artigo->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este endereço de slug já está cadastrado!</div>";
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
        $dados['resumo_publico'] = trim($dados_resumo_publico);
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_artigo?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE sts_artigos SET
                titulo='" . $dados_validos['titulo'] . "', 
                descricao='" . $dados_validos['descricao'] . "', 
                conteudo='" . $dados_validos['conteudo'] . "', 
                $campo_foto $valor_foto
                slug='" . $dados_validos['slug'] . "', 
                keywords='" . $dados_validos['keywords'] . "', 
                description='" . $dados_validos['description'] . "', 
                author='" . $dados_validos['author'] . "', 
                resumo_publico='" . $dados_resumo_publico . "', 
                sts_robot_id='" . $dados_validos['sts_robot_id'] . "', 
                adms_usuario_id='" . $dados_validos['adms_usuario_id'] . "', 
                sts_situacoe_id='" . $dados_validos['sts_situacoe_id'] . "', 
                sts_tps_artigo_id='" . $dados_validos['sts_tps_artigo_id'] . "',
                sts_cats_artigo_id='" . $dados_validos['sts_cats_artigo_id'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        echo $result_pg_up;
        mysqli_query($conn, $result_pg_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);    
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';                
                $destino = "../assets/imagens/artigo/" . $dados['id'] . "/";
                $destino_apagar = $destino.$dados_imagem_antiga;
                apagarFoto($destino_apagar);
                upload($foto, $destino, 1200, 627);
            }           
            $_SESSION['msg'] = "<div class='alert alert-success'>Artigo editado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_artigo';
            header("Location: $url_destino");
        } else {
            $dados['resumo_publico'] = trim($dados_resumo_publico);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não editado!</div>";
            $url_destino = pg . '/editar/sts_edit_artigo?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
