<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_pg_vis = "SELECT art.*,
            rb.nome nome_rb, rb.tipo tipo_rb,
            user.id id_user, user.nome nome_user,
            sit.nome nome_sit,
            crsit.cor cor_crsit,
            tpart.nome nome_tpart,
            catart.id id_catart, catart.nome nome_catart
            FROM sts_artigos art
            LEFT JOIN sts_robots rb ON rb.id=art.sts_robot_id
            INNER JOIN adms_usuarios user ON user.id=art.adms_usuario_id
            INNER JOIN sts_situacoes sit ON sit.id=art.sts_situacoe_id
            INNER JOIN sts_cors crsit ON crsit.id=sit.sts_cor_id
            INNER JOIN sts_tps_artigos tpart ON tpart.id=art.sts_tps_artigo_id
            INNER JOIN sts_cats_artigos catart ON catart.id=art.sts_cats_artigo_id
            WHERE art.id=$id  LIMIT 1";
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
                                <h2 class="display-4 titulo">Detalhes do Artigo</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_artigo', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/sts_edit_artigo', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/sts_edit_artigo?id=" . $row_pg_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_artigo', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_artigo?id=" . $row_pg_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/sts_list_artigo'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_artigo?id=" . $row_pg_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_artigo?id=" . $row_pg_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">
                            <dt class="col-sm-3">Imagem</dt>
                            <dd class="col-sm-9">
                                <?php
                                if (!empty($row_pg_vis['imagem'])) {
                                    echo "<img src='" . pgsite . "/assets/imagens/artigo/" . $row_pg_vis['id'] . "/" . $row_pg_vis['imagem'] . "' width='287' height='150'>";
                                }
                                ?>
                            </dd>

                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['id']; ?></dd>

                        </dl>
                        <h2 class="display-4 titulo">SEO</h2><hr>
                        <dl class="row">
                            <dt class="col-sm-3">Slug</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['slug']; ?></dd>

                            <dt class="col-sm-3">Palavra Chave</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['keywords']; ?></dd>

                            <dt class="col-sm-3">Autor SEO</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['author']; ?></dd>

                            <dt class="col-sm-3">Descrição SEO</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['description']; ?></dd>

                            <dt class="col-sm-3">Indexar</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['tipo_rb'] . " - " . $row_pg_vis['nome_rb']; ?></dd>

                            <dt class="col-sm-3">Tipo de Artigo</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['nome_tpart']; ?></dd>       

                            <dt class="col-sm-3">Quantidade de Acesso</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['qnt_acesso']; ?></dd>                     

                        </dl>
                        <h2 class="display-4 titulo">Conteúdo</h2><hr>
                        <dl class="row">                              

                            <dt class="col-sm-3">Titulo</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['titulo']; ?></dd>

                            <dt class="col-sm-3">Categoria de Artigo</dt>
                            <dd class="col-sm-9">
                                <a href="<?php echo pg . '/visualizar/sts_vis_cat_artigo?id=' . $row_pg_vis['id_catart']; ?>">
                                    <?php echo $row_pg_vis['nome_catart']; ?>
                                </a>
                            </dd>

                            <dt class="col-sm-3">Autor do Artigo</dt>
                            <dd class="col-sm-9">
                                <a href="<?php echo pg . '/visualizar/vis_usuario?id=' . $row_pg_vis['id_user']; ?>">
                                    <?php echo $row_pg_vis['nome_user']; ?>
                                </a>
                            </dd>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php
                                echo "<span class='badge badge-" . $row_pg_vis['cor_crsit'] . "'>" . $row_pg_vis['nome_sit'] . "</span>";
                                ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_pg_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_pg_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_pg_vis['modified']));
                                }
                                ?>
                            </dd>

                            <dt class="col-sm-3">Descrição</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['descricao']; ?></dd>                           

                            <dt class="col-sm-3">Resumo Público</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['resumo_publico']; ?></dd>

                            <dt class="col-sm-3">Conteúdo</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['conteudo']; ?></dd> 

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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Artigo não encontrado!</div>";
        $url_destino = pg . '/listar/sts_list_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}