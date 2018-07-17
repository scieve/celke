<?php
if (!isset($seg)) {
    exit;
}

$result_edit_prod = "SELECT * FROM sts_prods_homes WHERE id='1' LIMIT 1";
$resultado_edit_prod = mysqli_query($conn, $result_edit_prod);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_prod) AND ( $resultado_edit_prod->num_rows != 0)) {
    $row_edit_prod = mysqli_fetch_assoc($resultado_edit_prod);
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
                            <h2 class="display-4 titulo">Editar Produto</h2>
                        </div>                        
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_produto" enctype="multipart/form-data">                          
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>
                                    <span class="text-danger">*</span> Titulo
                                </label>
                                <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de produto" value="<?php
                                if (isset($_SESSION['dados']['titulo'])) {
                                    echo $_SESSION['dados']['titulo'];
                                } elseif (isset($row_edit_prod['titulo'])) {
                                    echo $row_edit_prod['titulo'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    <span class="text-danger">*</span> Subtitulo
                                </label>
                                <input name="subtitulo" type="text" class="form-control" placeholder="Subtitulo da área de produto" value="<?php
                                if (isset($_SESSION['dados']['subtitulo'])) {
                                    echo $_SESSION['dados']['subtitulo'];
                                } elseif (isset($row_edit_prod['subtitulo'])) {
                                    echo $row_edit_prod['subtitulo'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label><span class="text-danger">*</span> Descrição</label>
                            <textarea name="descricao" class="form-control" rows="6"><?php
                                if (isset($_SESSION['dados']['descricao'])) {
                                    echo $_SESSION['dados']['descricao'];
                                } elseif (isset($row_edit_prod['descricao'])) {
                                    echo $row_edit_prod['descricao'];
                                }
                                ?></textarea>
                        </div>

                        <div class="form-row">
                            <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_prod['imagem']; ?>">
                            <div class="form-group col-md-6">
                                <label> Foto (500x400):  </label>
                                <input type="file" name="imagem" onchange="previewImagem();">
                            </div>  
                            <div class="form-group col-md-6">
                                <?php
                                if (isset($row_edit_prod['imagem']) AND !empty($row_edit_prod['imagem'])) {
                                    $imagem_antiga = pgsite . '/assets/imagens/prods_home/' . $row_edit_prod['id'] . '/' . $row_edit_prod['imagem'];
                                } else {
                                    $imagem_antiga = pgsite . '/assets/imagens/prods_home/preview_img.png';
                                }
                                ?>
                                <img src="<?php echo $imagem_antiga; ?>" id="preview-user" class="img-thumbnail" style="width: 150px; height: 120px;">
                            </div>                       
                        </div>

                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditProd" type="submit" class="btn btn-warning" value="Salvar">
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
