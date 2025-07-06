<?php 
    require_once("templates/header.php");

    // Verifica se usuário está autenticado
    require_once("models/Professor.php");
    require_once("dao/ProfessorDAO.php");
    require_once("dao/AlunoDAO.php");

    require_once("helpers/utils.php");

    $professor = new Professor();
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $alunoDao = new AlunoDAO($conn, $BASE_URL);

    $professorData = $professorDao->verifyToken(true);

    $alunos = $alunoDao->getAlunos($professorData->id);

?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Gerencie seus alunos</p>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Status</th>
                <th scope="col" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach($alunos as $aluno): ?>
                <tr>
                    <td scope="row"><?= $aluno->id ?></td>
                    <td><a href="<?= $BASE_URL ?>aluno.php?id=<?= $aluno->id ?>" class="table-movie-title"><?= $aluno->nome ?></a></td>
                    <td><?= $aluno->email ?></td>
                    <td><?= statusAtivo($aluno->ativo) ?></td>
                    <td class="actions-column">
                        <a href="<?= $BASE_URL ?>editaraluno.php?id=<?= $aluno->id ?>" class="edit-btn">
                            <i class="far fa-edit"></i>
                        </a>
                        <form action="<?= $BASE_URL ?>aluno_process.php">

                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $aluno->id ?>">
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    require_once("templates/footer.php");
?>