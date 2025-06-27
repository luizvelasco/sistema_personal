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
            <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1><?= $professorData->nome ?></h1>
                        <p class="page-description">Altere seus dados no formulário abaixo:</p>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $professorData->nome ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite o seu nome" value="<?= $professorData->email ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Telefone:</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o seu nome" value="<?= $professorData->telefone ?>">
                        </div>
                        <input type="submit" class="btn form-btn" value="Alterar">
                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php
    require_once("templates/footer.php");
?>