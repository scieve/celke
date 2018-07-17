<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    //Pesquisar no banco de dados as informações na tabela sts_carousels
    $result_sts_pg = "SELECT id, ordem
                FROM sts_carousels
                WHERE id='$id' LIMIT 1";

    $resultado_sts_pg = mysqli_query($conn, $result_sts_pg);
    //Retornou algum valor do banco de dados acessa o IF, senão acessa ELSE
    if (($resultado_sts_pg) AND ( $resultado_sts_pg->num_rows != 0)) {
        $row_sts_pg = mysqli_fetch_assoc($resultado_sts_pg);

        //Pesquisar o ID do niveis_acessos_paginas a ser movido para baixo
        $ordem_num_menor = $row_sts_pg['ordem'] - 1;
        $result_sts_num_men = "SELECT id, ordem FROM sts_carousels 
            WHERE ordem='$ordem_num_menor' LIMIT 1";
        $resultado_sts_num_men = mysqli_query($conn, $result_sts_num_men);
        $row_sts_num_men = mysqli_fetch_assoc($resultado_sts_num_men);

        //Alterar a ordem do número menor para o número maior
        $result_ins_num_maior = "UPDATE sts_carousels SET
                ordem='" . $row_sts_pg['ordem'] . "', 
                modified=NOW()
                WHERE id='" . $row_sts_num_men['id'] . "'";
        $resultado_ins_num_maior = mysqli_query($conn, $result_ins_num_maior);

        //Alterar a ordem do número maior para o número menor
        $result_ins_num_menor = "UPDATE sts_carousels SET
                ordem='$ordem_num_menor',
                modified=NOW() 
                WHERE id='" . $row_sts_pg['id'] . "'";
        $resultado_ins_num_menor = mysqli_query($conn, $result_ins_num_menor);

        //Redirecionar conforme a situação do alterar: sucesso ou erro
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do carousel editado com sucesso!</div>";
            $url_destino = pg . "/listar/sts_list_carousel";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar a ordem do carousel!</div>";
            $url_destino = pg . "/listar/sts_list_carousel";
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>A ordem do carousel não pode ser alterado!</div>";
        $url_destino = pg . "/listar/sts_list_carousel";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Carousel não encontrado!</div>";
    $url_destino = pg . '/listar/sts_list_carousel';
    header("Location: $url_destino");
}
