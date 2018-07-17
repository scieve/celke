<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_emp_vis = "SELECT catart.*,
                            sit.nome nome_sit,
                            sitcor.cor cor_sitcor
                            FROM sts_cats_artigos catart
                            INNER JOIN sts_situacoes sit ON sit.id=catart.sts_situacoe_id
                            INNER JOIN sts_cors sitcor ON sitcor.id=sit.sts_cor_id
                            WHERE catart.id=$id
                            LIMIT 1";
    $resultado_emp_vis = mysqli_query($conn, $result_emp_vis);
    if (($resultado_emp_vis) AND ( $resultado_emp_vis->num_rows != 0)) {
        $row_emp_vis = mysqli_fetch_assoc($resultado_emp_vis);
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
                                <h2 class="display-4 titulo">Detalhes Categoria de Artigo</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_cat_artigo', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_cat_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/sts_edit_cat_artigo', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/sts_edit_cat_artigo?id=" . $row_emp_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_cat_artigo', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_cat_artigo?id=" . $row_emp_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/sts_list_cat_artigo'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_cat_artigo?id=" . $row_emp_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_cat_artigo?id=" . $row_emp_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_emp_vis['id']; ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9"><?php echo $row_emp_vis['nome']; ?></dd>
                            
                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php
                                echo "<span class='badge badge-" . $row_emp_vis['cor_sitcor'] . "'>" . $row_emp_vis['nome_sit'] . "</span>";
                                ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_emp_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_emp_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_emp_vis['modified']));
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Categoria de artigo não encontrado!</div>";
        $url_destino = pg . '/listar/sts_list_cat_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}