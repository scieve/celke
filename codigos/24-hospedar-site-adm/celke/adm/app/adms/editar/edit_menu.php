<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//verificar a existencia do id na URL
if (!empty($id)) {
    $result_edit_men = "SELECT * FROM adms_menus WHERE id='$id' LIMIT 1";
    $resultado_edit_men = mysqli_query($conn, $result_edit_men);
    //Verificar se encontrou a página no banco de dados
    if (($resultado_edit_men) AND ( $resultado_edit_men->num_rows != 0)) {
        $row_edit_men = mysqli_fetch_assoc($resultado_edit_men);
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
                                <h2 class="display-4 titulo">Editar Menu</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_menu', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_menu' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/vis_menu', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_menu?id=" . $row_edit_men['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_menu', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_menu?id=" . $row_edit_men['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_menu'>Listar</a>";
                                        }
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_menu?id=" . $row_edit_men['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_menu?id=" . $row_edit_men['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_menu">  
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_men['id'])) {
                                echo $row_edit_men['id'];
                            }
                            ?>">

                            <div class="form-group">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Nome do item de menu a ser apresentado no menu">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Nome
                                </label>
                                <input name="nome" type="text" class="form-control" placeholder="Nome do item de menu" value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (isset($row_edit_men['nome'])) {
                                    echo $row_edit_men['nome'];
                                }
                                ?>">
                            </div>


                            <div class="form-group">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Ícone
                                </label>
                                <input name="icone" type="text" class="form-control" placeholder="Ícone da página" value="<?php
                                if (isset($_SESSION['dados']['icone'])) {
                                    echo $_SESSION['dados']['icone'];
                                } elseif (isset($row_edit_men['icone'])) {
                                    echo $row_edit_men['icone'];
                                }
                                ?>">
                            </div>


                            <div class="form-group">
                                <?php
                                $result_sits = "SELECT id, nome FROM adms_sits ORDER BY nome ASC";
                                $resultado_sits = mysqli_query($conn, $result_sits);
                                ?>
                                <label>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a situação do menu.">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Situação
                                </label>
                                <select name="adms_sit_id" id="depend_pg" class="form-control">
                                    <option value="">Selecione</option>
                                    <?php
                                    while ($row_sits = mysqli_fetch_assoc($resultado_sits)) {
                                        if (isset($_SESSION['dados']['adms_sit_id']) AND ( $_SESSION['dados']['adms_sit_id'] == $row_sits['id'])) {
                                            echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                            
                                            
                                            
                                            //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                        } elseif (!isset($_SESSION['dados']['adms_sit_id']) AND ( isset($row_edit_men['adms_sit_id']) AND ( $row_edit_men['adms_sit_id'] == $row_sits['id']))) {
                                            echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                            
                                            
                                            
                                        } else {
                                            echo "<option value='" . $row_sits['id'] . "'>" . $row_sits['nome'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditMen" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>

                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
        unset($_SESSION['dados']);
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
        $url_destino = pg . '/listar/list_menu';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}