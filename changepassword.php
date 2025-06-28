<?php
    require_once("templates/header.php");
    require_once("models/Professor.php");
    require_once("dao/ProfessorDAO.php");

    $professor = new Professor();
    $professorDao = new ProfessorDAO($conn, $BASE_URL);

    $professorData = $professorDao->verifyToken(true);
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Alterar a senha:</h2>
                <p class="page-description">Digite a nova senha e confirme, para alterar sua senha:</p>
                <form action="<?= $BASE_URL ?>professor_process.php" method="post">
                    <input type="hidden" name="type" value="changepassword">
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua nova senha">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirmação de senha:</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a sua nova senha">
                    </div>
                    <input type="submit" class="btn form-btn" value="Alterar Senha">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>
