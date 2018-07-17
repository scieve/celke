<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//verificar a existencia do id na URL
if (!empty($id)) {
    $result_edit_pg = "SELECT * FROM sts_artigos WHERE id='$id' LIMIT 1";
    $resultado_edit_pg = mysqli_query($conn, $result_edit_pg);
    //Verificar se encontrou a página no banco de dados
    if (($resultado_edit_pg) AND ( $resultado_edit_pg->num_rows != 0)) {
        $row_edit_pg = mysqli_fetch_assoc($resultado_edit_pg);
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
                                <h2 class="display-4 titulo">Editar Artigo</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_artigo', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/sts_vis_artigo', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/sts_vis_artigo?id=" . $row_edit_pg['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_artigo', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_artigo?id=" . $row_edit_pg['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/sts_vis_artigo?id=" . $row_edit_pg['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_artigo?id=" . $row_edit_pg['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_artigo" enctype="multipart/form-data">  
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_pg['id'])) {
                                echo $row_edit_pg['id'];
                            }
                            ?>">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>
                                        <span class="text-danger">*</span> Titulo
                                    </label>
                                    <input name="titulo" type="text" class="form-control" id="nome" placeholder="Titulo do Artigo" value="<?php
                                    if (isset($_SESSION['dados']['titulo'])) {
                                        echo $_SESSION['dados']['titulo'];
                                    } elseif (isset($row_edit_pg['titulo'])) {
                                        echo $row_edit_pg['titulo'];
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label><span class="text-danger">*</span> Descrição</label>
                                <textarea name="descricao" id="editor-um" class="form-control" rows="6"><?php
                                    if (isset($_SESSION['dados']['descricao'])) {
                                        echo $_SESSION['dados']['descricao'];
                                    } elseif (isset($row_edit_pg['descricao'])) {
                                        echo $row_edit_pg['descricao'];
                                    }
                                    ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label><span class="text-danger">*</span> Conteúdo</label>
                                <textarea name="conteudo" id="editor-dois" class="form-control" rows="6"><?php
                                    if (isset($_SESSION['dados']['conteudo'])) {
                                        echo $_SESSION['dados']['conteudo'];
                                    } elseif (isset($row_edit_pg['conteudo'])) {
                                        echo $row_edit_pg['conteudo'];
                                    }
                                    ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label> Resumo Público</label>
                                <textarea name="resumo_publico" id="editor-tres" class="form-control" rows="6"><?php
                                    if (isset($_SESSION['dados']['resumo_publico'])) {
                                        echo $_SESSION['dados']['resumo_publico'];
                                    } elseif (isset($row_edit_pg['resumo_publico'])) {
                                        echo $row_edit_pg['resumo_publico'];
                                    }
                                    ?>
                                </textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <?php
                                    $result_cat_art = "SELECT id, nome FROM sts_cats_artigos ORDER BY nome ASC";
                                    $resultado_cat_art = mysqli_query($conn, $result_cat_art);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Categoria
                                    </label>
                                    <select name="sts_cats_artigo_id" id="sts_cats_artigo_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_pagina = mysqli_fetch_assoc($resultado_cat_art)) {
                                            if (isset($_SESSION['dados']['sts_cats_artigo_id']) AND ( $_SESSION['dados']['sts_cats_artigo_id'] == $row_pagina['id'])) {
                                                echo "<option value='" . $row_pagina['id'] . "' selected>" . $row_pagina['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['sts_cats_artigo_id']) AND ( isset($row_edit_pg['sts_cats_artigo_id']) AND ( $row_edit_pg['sts_cats_artigo_id'] == $row_pagina['id']))) {
                                                echo "<option value='" . $row_pagina['id'] . "' selected>" . $row_pagina['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_pagina['id'] . "'>" . $row_pagina['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <?php
                                    $result_user = "SELECT id, nome FROM adms_usuarios ORDER BY nome ASC";
                                    $resultado_user = mysqli_query($conn, $result_user);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Autor do Artigo
                                    </label>
                                    <select name="adms_usuario_id" id="adms_usuario_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_user = mysqli_fetch_assoc($resultado_user)) {
                                            if (isset($_SESSION['dados']['adms_usuario_id']) AND ( $_SESSION['dados']['adms_usuario_id'] == $row_user['id'])) {
                                                echo "<option value='" . $row_user['id'] . "' selected>" . $row_user['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['adms_usuario_id']) AND ( isset($row_edit_pg['adms_usuario_id']) AND ( $row_edit_pg['adms_usuario_id'] == $row_user['id']))) {
                                                echo "<option value='" . $row_user['id'] . "' selected>" . $row_user['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_user['id'] . "'>" . $row_user['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_pg['imagem']; ?>">
                                <div class="form-group col-md-6">
                                    <label> Foto(1200x627) </label>
                                    <input type="file" name="imagem" onchange="previewImagem();">
                                </div>  
                                <div class="form-group col-md-6">
                                    <?php
                                    if (isset($row_edit_pg['imagem'])) {
                                        $imagem_antiga = pgsite . '/assets/imagens/artigo/' . $row_edit_pg['id'] . '/' . $row_edit_pg['imagem'];
                                    } else {
                                        $imagem_antiga = pgsite . '/assets/imagens/artigo/preview_img.png';
                                    }
                                    ?>
                                    <img src="<?php echo $imagem_antiga; ?>" id="preview-user" class="img-thumbnail" style="width: 287px; height: 150px;">
                                </div>                       
                            </div>

                            <h2 class="display-4 titulo">SEO</h2><hr>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Principais palavras do artigo, por exemplo no artigo (como criar formulário com PHP): php, criar formulario. Máximo 180 letras.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        <span class="text-danger">*</span> Palavra chave
                                    </label>
                                    <input name="keywords" type="text" class="form-control" id="nome" placeholder="Palavra chave" value="<?php
                                    if (isset($_SESSION['dados']['keywords'])) {
                                        echo $_SESSION['dados']['keywords'];
                                    } elseif (isset($row_edit_pg['keywords'])) {
                                        echo $row_edit_pg['keywords'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Resumo do principal objetivo do artigo, máximo 180 letras.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        <span class="text-danger">*</span> Descrição
                                    </label>
                                    <input name="description" type="text" class="form-control" id="email" placeholder="Descrição do artigo ao SEO" value="<?php
                                    if (isset($_SESSION['dados']['description'])) {
                                        echo $_SESSION['dados']['description'];
                                    } elseif (isset($row_edit_pg['description'])) {
                                        echo $row_edit_pg['description'];
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Nome da empresa.">
                                            <i class="fas fa-question-circle"></i>
                                        </span><span class="text-danger">*</span> Autor
                                    </label>
                                    <input name="author" type="text" class="form-control" id="email" placeholder="Nome da empresa" value="<?php
                                    if (isset($_SESSION['dados']['author'])) {
                                        echo $_SESSION['dados']['author'];
                                    } elseif (isset($row_edit_pg['author'])) {
                                        echo $row_edit_pg['author'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Endereço do artigo, por exemplo no artigo (como criar formulário com PHP) inserir: como-criar-formulario-com-php.">
                                            <i class="fas fa-question-circle"></i>
                                        </span><span class="text-danger">*</span> Slug
                                    </label>
                                    <input name="slug" type="text" class="form-control" id="email" placeholder="Endereço do artigo" value="<?php
                                    if (isset($_SESSION['dados']['slug'])) {
                                        echo $_SESSION['dados']['slug'];
                                    } elseif (isset($row_edit_pg['slug'])) {
                                        echo $row_edit_pg['slug'];
                                    }
                                    ?>">
                                </div>  
                            </div>


                            <div class="form-row">  
                                <div class="form-group col-md-4">
                                    <?php
                                    $result_robots = "SELECT id, nome FROM sts_robots";
                                    $resultado_robots = mysqli_query($conn, $result_robots);
                                    ?>
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="A página deve ser indexada pelos buscadores.">
                                            <i class="fas fa-question-circle"></i>
                                        </span><span class="text-danger">*</span> Indexar
                                    </label>
                                    <select name="sts_robot_id" id="sts_robot_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_robots = mysqli_fetch_assoc($resultado_robots)) {
                                            if (isset($_SESSION['dados']['sts_robot_id']) AND ( $_SESSION['dados']['sts_robot_id'] == $row_robots['id'])) {
                                                echo "<option value='" . $row_robots['id'] . "' selected>" . $row_robots['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['sts_robot_id']) AND ( isset($row_edit_pg['sts_robot_id']) AND ( $row_edit_pg['sts_robot_id'] == $row_robots['id']))) {
                                                echo "<option value='" . $row_robots['id'] . "' selected>" . $row_robots['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_robots['id'] . "'>" . $row_robots['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>      
                                <div class="form-group col-md-4">
                                    <?php
                                    $result_tp_art = "SELECT id, nome FROM sts_tps_artigos ORDER BY nome ASC";
                                    $resultado_tp_art = mysqli_query($conn, $result_tp_art);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Tipo de Artigo
                                    </label>
                                    <select name="sts_tps_artigo_id" id="sts_tps_artigo_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_tp_art = mysqli_fetch_assoc($resultado_tp_art)) {
                                            if (isset($_SESSION['dados']['sts_tps_artigo_id']) AND ( $_SESSION['dados']['sts_tps_artigo_id'] == $row_tp_art['id'])) {
                                                echo "<option value='" . $row_tp_art['id'] . "' selected>" . $row_tp_art['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['sts_tps_artigo_id']) AND ( isset($row_edit_pg['sts_tps_artigo_id']) AND ( $row_edit_pg['sts_tps_artigo_id'] == $row_tp_art['id']))) {
                                                echo "<option value='" . $row_tp_art['id'] . "' selected>" . $row_tp_art['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_tp_art['id'] . "'>" . $row_tp_art['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <?php
                                    $result_sits = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                    $resultado_sits = mysqli_query($conn, $result_sits);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Situação
                                    </label>
                                    <select name="sts_situacoe_id" id="sts_situacoe_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_sit = mysqli_fetch_assoc($resultado_sits)) {
                                            if (isset($_SESSION['dados']['sts_situacoe_id']) AND ( $_SESSION['dados']['sts_situacoe_id'] == $row_sit['id'])) {
                                                echo "<option value='" . $row_sit['id'] . "' selected>" . $row_sit['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['sts_situacoe_id']) AND ( isset($row_edit_pg['sts_situacoe_id']) AND ( $row_edit_pg['sts_situacoe_id'] == $row_sit['id']))) {
                                                echo "<option value='" . $row_sit['id'] . "' selected>" . $row_sit['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_sit['id'] . "'>" . $row_sit['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditArt" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>

                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>
                <script>
                    function previewImagem() {
                        var imagem = document.querySelector('input[name=imagem').files[0];
                        var preview = document.querySelector('#preview-user');

                        var reader = new FileReader();

                        reader.onloadend = function () {
                            preview.src = reader.result;
                        }

                        if (imagem) {
                            reader.readAsDataURL(imagem);
                        } else {
                            preview.src = "";
                        }
                    }
                </script> 
                <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/classic/ckeditor.js"></script>
                <script>
                    ClassicEditor
                            .create(document.querySelector('#editor-um'))
                            .catch(error => {
                                console.error(error);
                            });
                    ClassicEditor
                            .create(document.querySelector('#editor-dois'))
                            .catch(error => {
                                console.error(error);
                            });
                    ClassicEditor
                            .create(document.querySelector('#editor-tres'))
                            .catch(error => {
                                console.error(error);
                            });
                </script>
            </div>
        </body>
        <?php
        unset($_SESSION['dados']);
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Artigo não encontrado!</div>";
        $url_destino = pg . '/listar/list_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}