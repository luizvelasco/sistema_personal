<?php
    require_once("templates/header.php");

    // Verifica se usuário está autenticado
    require_once("models/Professor.php");
    require_once("dao/ProfessorDAO.php");
    require_once("dao/AlunoDAO.php");
    $professor = new Professor();
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $alunoDao = new AlunoDAO($conn, $BASE_URL);
    $professorData = $professorDao->verifyToken(true);

    // Pega o ID do aluno via GET
    $aluno_id = filter_input(INPUT_GET, "aluno_id");

    $aluno = $alunoDao->findById($aluno_id, $professorData->id);
    if (!$aluno) {
        // Não encontrou o aluno, redireciona
        $message->setMessage("Aluno não encontrado", "error", "aluno.php");
        exit();
    }
?>

    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Avaliação</h1>
            <p class="page-description">Adicione a avaliação do aluno <?=  $aluno->nome ?></p>
            <form action="<?= $BASE_URL ?>avaliacao_process.php?aluno_id=<?= $aluno_id ?>" id="add-movie-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="data_avaliacao">Data da Avaliação</label>
                    <input type="text" class="form-control" id="data_avaliacao" name="data_avaliacao" placeholder="Digite a data da avaliação">
                </div>
                <div class="form-group">
                    <label for="peso">Peso</label>
                    <input type="text" class="form-control" id="peso" name="peso" placeholder="Digite o peso do aluno">
                </div>
                <div class="form-group">
                    <label for="percentual_gordura">Percentual de Gordura</label>
                    <input type="text" class="form-control" id="percentual_gordura" name="percentual_gordura" placeholder="Digite o percentual de gordura do aluno">
                </div>
                <div class="form-group">
                    <label for="percentual_massa_magra">Percentual de Massa Magra</label>
                    <input type="text" class="form-control" id="percentual_massa_magra" name="percentual_massa_magra" placeholder="Digite o percentual de massa magra do aluno">
                </div>
                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea name="observacoes" id="observacoes" class="form-control" rows="6"></textarea>
                </div>
               
                <input type="submit" class="btn card-btn" value="Adicionar Aluno">
            </form>
        </div>
    </div>
    
<?php
    require_once("templates/footer.php");
?>