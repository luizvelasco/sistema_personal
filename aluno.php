<?php
    require_once("templates/header.php");
    require_once("models/Message.php");

    require_once("models/Aluno.php");
    require_once("dao/AlunoDAO.php");

    require_once("models/Professor.php");
    require_once("dao/ProfessorDAO.php");

    $professor = new Professor();
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $professorData = $professorDao->verifyToken(true);
    $professor_id = $professorData->id;

    $alunoDao = new AlunoDAO($conn, $BASE_URL);

    // Pega o ID via GET
    $id = filter_input(INPUT_GET, "id");

    if (!$id) {
        // Redireciona se não tiver ID
        header("Location: index.php");
        exit();
    }

    // Busca aluno pelo ID
    $aluno = $alunoDao->findById($id, $professor_id);

    if (!$aluno) {
        $message->setMessage("Aluno inexistente", "error", "index.php");
    }
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-3 col-md-6 bg-light text-dark p-4 rounded">
        <h1 class="page-title text-center">Visualizar Aluno</h1>

        <?php if ($aluno->foto): ?>
            <div class="text-center mb-3">
                <img src="<?= $BASE_URL ?>img/alunos/<?= $aluno->foto ?>" alt="<?= $aluno->nome ?>" class="img-fluid rounded" style="max-width: 200px;">
            </div>
        <?php endif; ?>

        <ul class="list-group">
            <li class="list-group-item"><strong>Nome:</strong> <?= $aluno->nome ?></li>
            <li class="list-group-item"><strong>E-mail:</strong> <?= $aluno->email ?></li>
            <li class="list-group-item"><strong>Telefone:</strong> <?= $aluno->telefone ?></li>
            <li class="list-group-item"><strong>Data de Nascimento:</strong> <?= date("d/m/Y", strtotime($aluno->data_nascimento)) ?></li>
            <li class="list-group-item"><strong>Gênero:</strong> <?= $aluno->genero ?></li>
            <li class="list-group-item"><strong>Ativo:</strong> <?= $aluno->ativo ? "Sim" : "Não" ?></li>
            <li class="list-group-item"><strong>Data de Inclusão:</strong> <?= date("d/m/Y", strtotime($aluno->criado_em)) ?></li>
            <li class="list-group-item"><strong>Última Alteração:</strong> <?= date("d/m/Y", strtotime($aluno->atualizado_em)) ?></li>
        </ul>

        <div class="mt-4 d-flex justify-content-between">
            <a href="<?= $BASE_URL ?>avaliacoes.php?aluno_id=<?= $aluno->id ?>" class="btn btn-primary">Ver Avaliações</a>
            <a href="<?= $BASE_URL ?>aluno_edit.php?id=<?= $aluno->id ?>" class="btn btn-secondary">Editar</a>
            <a href="<?= $BASE_URL ?>index.php" class="btn btn-light">Voltar</a>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>
