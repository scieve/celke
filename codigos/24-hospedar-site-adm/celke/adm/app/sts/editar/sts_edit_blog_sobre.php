<?php
if (!isset($seg)) {
    exit;
}

$result_edit_sob = "SELECT * FROM sts_blogs_sobres WHERE id='1' LIMIT 1";
$resultado_edit_sob = mysqli_query($conn, $result_edit_sob);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_sob) AND ( $resultado_edit_sob->num_rows != 0)) {
    $row_edit_sob = mysqli_fetch_assoc($resultado_edit_sob);
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
                            <h2 class="display-4 titulo">Editar Sobre Autor</h2>
                        </div>                        
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_blog_sobre" enctype="multipart/form-data">                          
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>
                                    <span class="text-danger">*</span> Titulo
                                </label>
                                <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de produto" value="<?php
                                if (isset($_SESSION['dados']['titulo'])) {
                                    echo $_SESSION['dados']['titulo'];
                                } elseif (isset($row_edit_sob['titulo'])) {
                                    echo $row_edit_sob['titulo'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                $result_sits = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                $resultado_sits = mysqli_query($conn, $result_sits);
                                ?>
                                <label>
                                    <span class="text-danger">*</span> Situação
                                </label>
                                <select name="sts_situacoe_id" id="sts_situacaos_pg_id" class="form-control">
                                    <option value="">Selecione</option>
                                    <?php
                                    while ($row_sits = mysqli_fetch_assoc($resultado_sits)) {
                                        if (isset($_SESSION['dados']['sts_situacoe_id']) AND ( $_SESSION['dados']['sts_situacoe_id'] == $row_sits['id'])) {
                                            echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                            //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                        } elseif (!isset($_SESSION['dados']['sts_situacoe_id']) AND ( isset($row_edit_sob['sts_situacoe_id']) AND ( $row_edit_sob['sts_situacoe_id'] == $row_sits['id']))) {
                                            echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row_sits['id'] . "'>" . $row_sits['nome'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><span class="text-danger">*</span> Descrição</label>
                            <textarea name="descricao" class="form-control" rows="6"><?php
                                if (isset($_SESSION['dados']['descricao'])) {
                                    echo $_SESSION['dados']['descricao'];
                                } elseif (isset($row_edit_sob['descricao'])) {
                                    echo $row_edit_sob['descricao'];
                                }
                                ?></textarea>
                        </div>

                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditBlogSob" type="submit" class="btn btn-warning" value="Salvar">
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
        </div>
    </body>
    <?php
    unset($_SESSION['dados']);
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Serviços não encontrado!</div>";
    $url_destino = pg . '/visualizar/home';
    header("Location: $url_destino");
}
