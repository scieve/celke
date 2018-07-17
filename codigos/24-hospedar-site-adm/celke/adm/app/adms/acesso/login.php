<?php
if (!isset($seg)) {
    exit;
}
include_once 'app/adms/include/head_login.php';
?>
<body class="text-center">
    <form class="form-signin" method="POST" action="<?php echo pg. '/acesso/valida'; ?>">
        <img class="mb-4" src="<?php echo pg; ?>/assets/imagens/logo_login/logo_celke.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Área Restrita</h1>
        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if(isset($_SESSION['msgcad'])){
            echo $_SESSION['msgcad'];
            unset($_SESSION['msgcad']);
        }
        ?>
        <div class="form-group">
            <label>Usuário</label>
            <input name="usuario" type="text" class="form-control" placeholder="Digite o usuário" required>               
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input name="senha" type="password" class="form-control" placeholder="Digite a senha" required>
        </div>
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar" name="SendLogin">
        <p class="text-center">
            <a href="<?php echo pg.'/cadastrar/cad_user_login'; ?>">Cadastrar</a> - <a href="<?php echo pg.'/acesso/recuper_login'; ?>">Esqueceu a senha?</a>
        </p>
    </form>
</body>
