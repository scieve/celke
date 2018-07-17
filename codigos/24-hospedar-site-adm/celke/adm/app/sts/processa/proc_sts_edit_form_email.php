<?php

if (!isset($seg)) {
    exit;
}
$SendEditFormEmail = filter_input(INPUT_POST, 'SendEditFormEmail', FILTER_SANITIZE_STRING);
if ($SendEditFormEmail) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //Retirar campo da validação vazio
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['imagem_antiga']);

    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar o formulário inserir e-mail da página inicial!</div>";
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
        $url_destino = pg . '/editar/sts_edit_form_email';
        header("Location: $url_destino");
    } else {
        $result_ser_up = "UPDATE sts_forms_emails SET
                titulo='" . $dados_validos['titulo'] . "', 
                descricao='" . $dados_validos['descricao'] . "', 
                titulo_botao='" . $dados_validos['titulo_botao'] . "',
                $campo_foto $valor_foto
                modified=NOW() 
                WHERE id='1'";

        mysqli_query($conn, $result_ser_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';
                $destino = "../assets/imagens/form_email/1/";
                $destino_apagar = $destino . $dados_imagem_antiga;
                apagarFoto($destino_apagar);
                upload($foto, $destino, 1920, 846);
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário inserir e-mail da página inicial editado com sucesso!</div>";
            $url_destino = pg . '/editar/sts_edit_form_email';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário inserir e-mail da página inicial não foi editado!</div>";
            $url_destino = pg . '/editar/sts_edit_form_email';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
