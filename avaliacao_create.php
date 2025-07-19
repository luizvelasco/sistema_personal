<?php
    require_once("templates/header.php");

    // Verifica se usuário está autenticado
    require_once("models/Professor.php");
    require_once("dao/ProfessorDAO.php");
    $professor = new Professor();
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $professorData = $professorDao->verifyToken(true);
?>

    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Avaliação</h1>
            <p class="page-description">Adicione a avaliação do aluno XXX</p>
            <form action="<?= $BASE_URL ?>avaliacao_process.php" id="add-movie-form" method="post" enctype="multipart/form-data">
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
                    <label for="genero">Gênero</label>
                    <select class="form-control" name="genero" id="genero">
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control-file" name="foto" id="foto">
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar Aluno">
            </form>
        </div>
    </div>
    
<?php
    require_once("templates/footer.php");
?>