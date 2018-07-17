<?php

if (!isset($seg)) {
    exit;
}
$SendEditCar = filter_input(INPUT_POST, 'SendEditCar', FILTER_SANITIZE_STRING);
if ($SendEditCar) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['imagem_antiga']);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar o carousel!</div>";
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
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_carousel?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE sts_carousels SET
                nome='" . $dados_validos['nome'] . "', 
                $campo_foto $valor_foto
                titulo='" . $dados_validos['titulo'] . "', 
                descricao='" . $dados_validos['descricao'] . "', 
                posicao_text='" . $dados_validos['posicao_text'] . "', 
                titulo_botao='" . $dados_validos['titulo_botao'] . "', 
                link='" . $dados_validos['link'] . "', 
                sts_cor_id='" . $dados_validos['sts_cor_id'] . "', 
                sts_situacoe_id='" . $dados_validos['sts_situacoe_id'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        
        mysqli_query($conn, $result_pg_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);    
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';                
                $destino = "../assets/imagens/carousel/" . $dados['id'] . "/";
                $destino_apagar = $destino.$dados_imagem_antiga;
                apagarFoto($destino_apagar);
                upload($foto, $destino, 1920, 848);
            }           
            $_SESSION['msg'] = "<div class='alert alert-success'>Carousel editado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_carousel';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Carousel não foi editado!</div>";
            $url_destino = pg . '/editar/sts_edit_carousel?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
