<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_pg_vis = "SELECT pg.*,
            tpg.tipo tipo_tpg, tpg.nome nome_tpg,
            rb.nome nome_rb, rb.tipo tipo_rb,
            sitpg.nome nome_sitpg,
            crsit.cor cor_crsit,
            depg.id id_depg, depg.nome_pagina nome_depg
            FROM sts_paginas pg
            LEFT JOIN sts_tps_pgs tpg ON tpg.id=pg.sts_tps_pg_id
            LEFT JOIN sts_robots rb ON rb.id=pg.sts_robot_id
            INNER JOIN sts_situacaos_pgs sitpg ON sitpg.id=pg.sts_situacaos_pg_id
            INNER JOIN sts_cors crsit ON crsit.id=sitpg.sts_cor_id
            LEFT JOIN sts_paginas depg ON depg.id=pg.depend_pg
            WHERE pg.id=$id  LIMIT 1";
    $resultado_pg_vis = mysqli_query($conn, $result_pg_vis);
    if (($resultado_pg_vis) AND ( $resultado_pg_vis->num_rows != 0)) {
        $row_pg_vis = mysqli_fetch_assoc($resultado_pg_vis);
        include_once 'app/adms/include/head.php';
        ?>
        <body>    
            <?php
            include_once 'app/adms/include/header.php';
            ?>
            <div class="d-flex">
                <?php
                include_once 'app/adms/include/menu.php';
                ?>
                <div class="content p-1">
                    <div class="list-group-item">
                        <div class="d-flex">
                            <div class="mr-auto p-2">
                                <h2 class="display-4 titulo">Detalhes da Página do Site</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_pagina', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_pagina' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/sts_edit_pagina', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/sts_edit_pagina?id=" . $row_pg_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_pagina', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_pagina?id=" . $row_pg_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($btn_list) {
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/sts_list_pagina'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_pagina?id=" . $row_pg_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_pagina?id=" . $row_pg_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['id']; ?></dd>

                            <dt class="col-sm-3">Nome Página</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['nome_pagina']; ?></dd>

                            <dt class="col-sm-3">Endereço</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['endereco']; ?></dd>

                            <dt class="col-sm-3">Observação</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['obs']; ?></dd>

                            <dt class="col-sm-3">Palavra Chave</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['keywords']; ?></dd>

                            <dt class="col-sm-3">Descrição</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['description']; ?></dd>

                            <dt class="col-sm-3">Autor</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['author']; ?></dd>

                            <dt class="col-sm-3">Dependente</dt>
                            <dd class="col-sm-9"><?php
                                if ($row_pg_vis['depend_pg'] != 0) {
                                    echo "<a href='" . pg . "/visualizar/sts_vis_pagina?id=" . $row_pg_vis['id_depg'] . "'>" . $row_pg_vis['nome_depg'] . "</a>";
                                } else {
                                    echo "<span class='badge badge-danger'>Não</span>";
                                }
                                ?>
                            </dd>

                            <dt class="col-sm-3">Tipo</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['tipo_tpg'] . " - " . $row_pg_vis['nome_tpg']; ?></dd>

                            <dt class="col-sm-3">Indexar</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['tipo_rb'] . " - " . $row_pg_vis['nome_rb']; ?></dd>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php 
                            echo "<span class='badge badge-".$row_pg_vis['cor_crsit']."'>".$row_pg_vis['nome_sitpg']."</span>";
                            ?></dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_pg_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_pg_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_pg_vis['modified']));
                                }
                                ?></dd>

                        </dl>
                    </div>
                </div>
                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
        $url_destino = pg . '/listar/sts_list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}