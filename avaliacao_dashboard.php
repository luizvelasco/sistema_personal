<?php 
    require_once("templates/header.php");

    // Verifica se usuário está autenticado
    require_once("models/Professor.php");
    require_once("models/Message.php");
    require_once("dao/ProfessorDAO.php");
    require_once("models/Avaliacao.php");
    require_once("dao/AvaliacaoDAO.php");
    require_once("dao/AlunoDAO.php");

    $professor = new Professor();
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $alunoDao = new AlunoDAO($conn, $BASE_URL);
    $avaliacaoDAO = new AvaliacaoDAO($conn, $BASE_URL);
    

    $professorData = $professorDao->verifyToken(true);

    // Pega o ID do aluno via GET
    $aluno_id = filter_input(INPUT_GET, "aluno_id");

    $aluno = $alunoDao->findById($aluno_id, $professorData->id);

    if (!$aluno) {
        // Não encontrou o aluno, redireciona
        $message->setMessage("Aluno não encontrado", "error", "aluno.php");
        exit();
    }

    $avaliacoes = $avaliacaoDAO->getAvaliacoes($aluno_id);

?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description"><?= $aluno->nome ?></p>
     <a href="<?= $BASE_URL ?>avaliacao_create.php?aluno_id=<?= $aluno_id ?>" class="btn btn-primary card-btn">Cadastrar Avaliação</a>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Data da Avaliação</th>
                <th scope="col">Peso</th>
                <th scope="col">% Gordura</th>
                <th scope="col">% Massa Magra</th>
                <th scope="col" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach($avaliacoes as $avaliacao): ?>
                <tr>
                    <td scope="row"><?= $avaliacao->id ?></td>
                    <td scope="row"><?= date("d/m/Y", strtotime($avaliacao->data_avaliacao)) ?></td>
                    <td scope="row"><?= $avaliacao->peso ?></td>
                    <td scope="row"><?= $avaliacao->percentual_gordura ?></td>
                    <td scope="row"><?= $avaliacao->percentual_massa_magra ?></td>
                    <td class="actions-column">
                        <a href="<?= $BASE_URL ?>avaliacao_edit.php?id=<?= $avaliacao->id ?>" class="edit-btn">
                            <i class="far fa-edit"></i>
                        </a>
                        <form action="<?= $BASE_URL ?>avaliacao_process.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?')">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $avaliacao->id ?>">
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