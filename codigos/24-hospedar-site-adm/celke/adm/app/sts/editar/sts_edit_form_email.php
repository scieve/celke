<?php
if (!isset($seg)) {
    exit;
}

$result_edit_form = "SELECT * FROM sts_forms_emails WHERE id='1' LIMIT 1";
$resultado_edit_form = mysqli_query($conn, $result_edit_form);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_form) AND ( $resultado_edit_form->num_rows != 0)) {
    $row_edit_form = mysqli_fetch_assoc($resultado_edit_form);
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
                            <h2 class="display-4 titulo">Editar Formulário de E-mail</h2>
                        </div>                        
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_form_email" enctype="multipart/form-data">                          
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>
                                    <span class="text-danger">*</span> Titulo
                                </label>
                                <input name="titulo" type="text" class="form-control" placeholder="Titulo da área formulário de e-mail" value="<?php
                                if (isset($_SESSION['dados']['titulo'])) {
                                    echo $_SESSION['dados']['titulo'];
                                } elseif (isset($row_edit_form['titulo'])) {
                                    echo $row_edit_form['titulo'];
                                }
                                ?>">
                            </div>
                        </div>
                         <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>
                                    <span class="text-danger">*</span> Descrição
                                </label>
                                <input name="descricao" type="text" class="form-control" placeholder="Descrição da área formulário de e-mail" value="<?php
                                if (isset($_SESSION['dados']['descricao'])) {
                                    echo $_SESSION['dados']['descricao'];
                                } elseif (isset($row_edit_form['descricao'])) {
                                    echo $row_edit_form['descricao'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>
                                    <span class="text-danger">*</span> Texto do Botão
                                </label>
                                <input name="titulo_botao" type="text" class="form-control" placeholder="Texto do botão" value="<?php
                                if (isset($_SESSION['dados']['titulo_botao'])) {
                                    echo $_SESSION['dados']['titulo_botao'];
                                } elseif (isset($row_edit_form['titulo_botao'])) {
                                    echo $row_edit_form['titulo_botao'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_form['imagem']; ?>">
                            <div class="form-group col-md-6">
                                <label> Foto (1920x846):  </label>
                                <input type="file" name="imagem" onchange="previewImagem();">
                            </div>  
                            <div class="form-group col-md-6">
                                <?php
                                if (isset($row_edit_form['imagem']) AND !empty($row_edit_form['imagem'])) {
                                    $imagem_antiga = pgsite . '/assets/imagens/form_email/' . $row_edit_form['id'] . '/' . $row_edit_form['imagem'];
                                } else {
                                    $imagem_antiga = pgsite . '/assets/imagens/form_email/preview_img.png';
                                }
                                ?>
                                <img src="<?php echo $imagem_antiga; ?>" id="preview-user" class="img-thumbnail" style="width: 250px; height: 110px;">
                            </div>                       
                        </div>

                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditFormEmail" type="submit" class="btn btn-warning" value="Salvar">
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
