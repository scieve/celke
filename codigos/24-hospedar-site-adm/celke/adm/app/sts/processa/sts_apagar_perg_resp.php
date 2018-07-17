<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Pesquisar no banco de dados se há carousel com ordem acima do qual será apagada
    $result_men_ver = "SELECT id, ordem AS ordem_result FROM sts_pergs_resps WHERE ordem > (SELECT ordem FROM sts_pergs_resps WHERE id='$id') ORDER BY ordem ASC";
    $resultado_men_ver = mysqli_query($conn, $result_men_ver);

    //Apagar a página
    $result_perg_del = "DELETE FROM sts_pergs_resps WHERE id='$id'";
    mysqli_query($conn, $result_perg_del);
    if (mysqli_affected_rows($conn)) {

        //Alterar a sequencia da ordem para não deixar nenhum número da ordem vazio
        if (($resultado_men_ver) AND ( $resultado_men_ver->num_rows != 0)) {
            while ($row_men_ver = mysqli_fetch_assoc($resultado_men_ver)) {
                $row_men_ver['ordem_result'] = $row_men_ver['ordem_result'] - 1;
                $result_men_or = "UPDATE sts_pergs_resps SET
                   ordem='" . $row_men_ver['ordem_result'] . "', 
                   modified=NOW()
                   WHERE id='" . $row_men_ver['id'] . "'";
                mysqli_query($conn, $result_men_or);
            }
        }

        $_SESSION['msg'] = "<div class='alert alert-success'>Pergunta e Resposta apagado com sucesso!</div>";
        $url_destino = pg . '/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O pergunta e resposta não foi apagado!</div>";
        $url_destino = pg . '/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

