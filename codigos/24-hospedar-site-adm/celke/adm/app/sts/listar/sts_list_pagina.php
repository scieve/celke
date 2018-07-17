<?php
if (!isset($seg)) {
    exit;
}
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
                        <h2 class="display-4 titulo">Listar Páginas do Site</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregar_btn('cadastrar/sts_cad_pagina', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/sts_cad_pagina' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                //Receber o número da página
                $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
                $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                //Setar a quantidade de itens por pagina
                $qnt_result_pg = 40;

                //Calcular o inicio visualização
                $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
                if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                    $resul_pg = "SELECT pg.id, pg.nome_pagina, pg.lib_bloq, pg.ordem,
                            tpg.tipo
                            FROM sts_paginas pg
                            LEFT JOIN sts_tps_pgs tpg ON tpg.id=pg.sts_tps_pg_id
                            ORDER BY pg.ordem ASC LIMIT $inicio, $qnt_result_pg";
                } else {
                    $resul_pg = "SELECT pg.id, pg.nome_pagina, pg.lib_bloq, pg.ordem,
                            tpg.tipo
                            FROM sts_paginas pg
                            LEFT JOIN sts_tps_pgs tpg ON tpg.id=pg.sts_tps_pg_id
                            WHERE pg.depend_pg=0                            
                            ORDER BY pg.ordem ASC LIMIT $inicio, $qnt_result_pg";
                }
                $resultado_pg = mysqli_query($conn, $resul_pg);
                if (($resultado_pg) AND ( $resultado_pg->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="d-none d-sm-table-cell">Tipo Página</th>
                                    <th class="d-none d-sm-table-cell text-center">Menu</th>
                                    <th class="d-none d-sm-table-cell text-center">Ordem</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qnt_linhas_exe = 1;
                                while ($row_pg = mysqli_fetch_assoc($resultado_pg)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row_pg['id']; ?></td>
                                        <td><?php echo $row_pg['nome_pagina']; ?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo $row_pg['tipo']; ?></td>
                                        <td class="d-none d-sm-table-cell text-center"><?php
                                            $btn_lib_per = carregar_btn('processa/proc_sts_lib_menu', $conn);
                                            if ($btn_lib_per) {
                                                if ($row_pg['lib_bloq'] == 1) {
                                                    echo "<a href='" . pg . "/processa/proc_sts_lib_menu?id=" . $row_pg['id'] . "' class='badge badge-pill badge-success'>Sim</a>";
                                                } else {
                                                    echo "<a href='" . pg . "/processa/proc_sts_lib_menu?id=" . $row_pg['id'] . "' class='badge badge-pill badge-danger'>Não</a>";
                                                }
                                            } else {
                                                if ($row_pg['lib_bloq'] == 1) {
                                                    echo "<span class='badge badge-pill badge-success'>Sim</span>";
                                                } else {
                                                    echo "<span class='badge badge-pill badge-danger'>Não</span>";
                                                }
                                            }
                                            ?></td>
                                        <td class="d-none d-sm-table-cell text-center"><?php echo $row_pg['ordem']; ?></td>
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php
                                                $btn_vis = carregar_btn('visualizar/sts_vis_pagina', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/sts_vis_pagina?id=" . $row_pg['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_edit = carregar_btn('editar/sts_edit_pagina', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/sts_edit_pagina?id=" . $row_pg['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                                }
                                                $btn_apagar = carregar_btn('processa/sts_apagar_pagina', $conn);
                                                if ($btn_apagar) {
                                                    echo "<a href='" . pg . "/processa/sts_apagar_pagina?id=" . $row_pg['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                                }
                                                $btn_ordem_menu = carregar_btn('processa/proc_sts_ordem_menu', $conn);
                                                if ($btn_ordem_menu) {
                                                    if ($qnt_linhas_exe == 1) {
                                                        echo "<button type='button' class='btn btn-sm btn-info disabled'>";
                                                        echo "<i class='fas fa-angle-double-up'></i>";
                                                        echo "</button> ";
                                                    } else {
                                                        echo "<a href='" . pg . "/processa/proc_sts_ordem_menu?id=" . $row_pg['id'] . "'><button type='button' class='btn btn-sm btn-info'>";
                                                        echo "<i class='fas fa-angle-double-up'></i>";
                                                        echo "</button></a> ";
                                                    }
                                                    $qnt_linhas_exe++;
                                                }
                                                ?>

                                            </span>
                                            <div class="dropdown d-block d-md-none">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                    <?php
                                                    if ($btn_vis) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/sts_vis_pagina?id=" . $row_pg['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_pagina?id=" . $row_pg['id'] . "'>Editar</a>";
                                                    }
                                                    if ($btn_apagar) {
                                                        echo "<a class='dropdown-item' href=''" . pg . "/processa/sts_apagar_pagina' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php
                        if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                            $result_pg = "SELECT COUNT(id) AS num_result FROM sts_paginas";
                        } else {
                            $result_pg = "SELECT COUNT(id) AS num_result 
                                FROM sts_paginas
                                WHERE depend_pg=0";
                        }

                        $resultado_pg = mysqli_query($conn, $result_pg);
                        $row_pg = mysqli_fetch_assoc($resultado_pg);
                        //echo $row_pg['num_result'];
                        //Quantidade de pagina 
                        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                        //Limitar os link antes depois
                        $max_links = 2;
                        echo "<nav aria-label='paginacao-blog'>";
                        echo "<ul class='pagination pagination-sm justify-content-center'>";
                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/list_pagina?pagina=1' tabindex='-1'>Primeira</a>";
                        echo "</li>";

                        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                            if ($pag_ant >= 1) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_pagina?pagina=$pag_ant'>$pag_ant</a></li>";
                            }
                        }

                        echo "<li class='page-item active'>";
                        echo "<a class='page-link' href='#'>$pagina</a>";
                        echo "</li>";

                        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                            if ($pag_dep <= $quantidade_pg) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_pagina?pagina=$pag_dep'>$pag_dep</a></li>";
                            }
                        }

                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/list_pagina?pagina=$quantidade_pg'>Última</a>";
                        echo "</li>";
                        echo "</ul>";
                        echo "</nav>";
                        ?>                        
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Nenhum registro encontrado!
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


