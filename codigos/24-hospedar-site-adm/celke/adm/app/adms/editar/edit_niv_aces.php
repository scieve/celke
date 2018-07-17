<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
        $result_nivac_ed = "SELECT * FROM adms_niveis_acessos WHERE id=$id LIMIT 1";
    } else {
        $result_nivac_ed = "SELECT * FROM adms_niveis_acessos WHERE ordem > '" . $_SESSION['ordem'] . "' AND id=$id LIMIT 1";
    }

    $resultado_nivac_ed = mysqli_query($conn, $result_nivac_ed);
    if (($resultado_nivac_ed) AND ( $resultado_nivac_ed->num_rows != 0)) {
        $row_nivac_ed = mysqli_fetch_assoc($resultado_nivac_ed);
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
                                <h2 class="display-4 titulo">Editar Nível de Acesso</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_niv_aces', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_niv_aces' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/vis_niv_aces', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_niv_aces?id=" . $row_nivac_ed['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_niv_aces', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_niv_aces?id=" . $row_nivac_ed['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_niv_aces'>Listar</a>";
                                        }
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_niv_aces?id=" . $row_nivac_ed['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_niv_aces?id=" . $row_nivac_ed['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_niv_aces">                    
                            <input type="hidden" name="id" value="<?php if (isset($row_nivac_ed['id'])) {
                    echo $row_nivac_ed['id'];
                } ?>">

                            <div class="form-group">
                                <label><span class="text-danger">*</span> Nome</label>
                                <input name="nome" type="text" class="form-control" placeholder="Nome do nível de acesso" value="<?php if (isset($row_nivac_ed['nome'])) {
                    echo $row_nivac_ed['nome'];
                } ?>">
                            </div>
                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditNivAc" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>
        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>

            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Nível de acesso não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $url_destino = pg . '/listar/list_niv_aces';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Nível de acesso não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $url_destino = pg . '/listar/list_niv_aces';
    header("Location: $url_destino");
}


