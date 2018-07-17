<?php
if (!isset($seg)) {
    exit;
}

$result_edit_vid = "SELECT * FROM sts_videos WHERE id='1' LIMIT 1";
$resultado_edit_vid = mysqli_query($conn, $result_edit_vid);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_vid) AND ( $resultado_edit_vid->num_rows != 0)) {
    $row_edit_vid = mysqli_fetch_assoc($resultado_edit_vid);
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
                            <h2 class="display-4 titulo">Editar Vídeos</h2>
                        </div>                        
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_video" enctype="multipart/form-data">                          
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>
                                    <span class="text-danger">*</span> Titulo
                                </label>
                                <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de vídeo" value="<?php
                                if (isset($_SESSION['dados']['titulo'])) {
                                    echo $_SESSION['dados']['titulo'];
                                } elseif (isset($row_edit_vid['titulo'])) {
                                    echo $row_edit_vid['titulo'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    <span class="text-danger">*</span> Titulo
                                </label>
                                <input name="descricao" type="text" class="form-control" placeholder="Descrição da área de vídeo" value="<?php
                                if (isset($_SESSION['dados']['descricao'])) {
                                    echo $_SESSION['dados']['descricao'];
                                } elseif (isset($row_edit_vid['descricao'])) {
                                    echo $row_edit_vid['descricao'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>
                                    <span class="text-danger">*</span> Vídeo 1
                                </label>
                                <textarea name="video_um" class="form-control" rows="5"><?php
                                    if (isset($_SESSION['dados']['video_um'])) {
                                        echo $_SESSION['dados']['video_um'];
                                    } elseif (isset($row_edit_vid['video_um'])) {
                                        echo $row_edit_vid['video_um'];
                                    }
                                    ?>
                                </textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> Vídeo 2</label>
                                <textarea name="video_dois" class="form-control" rows="5"><?php
                                    if (isset($_SESSION['dados']['video_dois'])) {
                                        echo $_SESSION['dados']['video_dois'];
                                    } elseif (isset($row_edit_vid['video_dois'])) {
                                        echo $row_edit_vid['video_dois'];
                                    }
                                    ?>
                                </textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label> 
                                    <span class="text-danger">*</span> Vídeo 3
                                </label>
                                <textarea name="video_tres" class="form-control" rows="5"><?php
                                    if (isset($_SESSION['dados']['video_tres'])) {
                                        echo $_SESSION['dados']['video_tres'];
                                    } elseif (isset($row_edit_vid['video_tres'])) {
                                        echo $row_edit_vid['video_tres'];
                                    }
                                    ?>
                                </textarea>
                            </div>
                        </div>

                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditVideo" type="submit" class="btn btn-warning" value="Salvar">
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Serviços não encontrado!</div>";
    $url_destino = pg . '/visualizar/home';
    header("Location: $url_destino");
}
