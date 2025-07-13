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
        <div class="row">
            <!-- Formulário de dados -->
            <div class="col-md-6">
                <h1><?= $professorData->nome ?></h1>
                <p class="page-description">Altere seus dados no formulário abaixo:</p>
                <form action="<?= $BASE_URL ?>professor_process.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">

                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o seu nome" value="<?= $professorData->nome ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email" value="<?= $professorData->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $professorData->telefone ?>">
                    </div>
                    <input type="submit" class="btn form-btn" value="Alterar">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>
