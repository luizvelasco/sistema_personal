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
            <h1 class="page-title">Adicionar Aluno</h1>
            <p class="page-description">Adicione seu aluno para acompanhamento</p>
            <form action="<?= $BASE_URL ?>aluno_process.php" id="add-movie-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do aluno">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail do aluno">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone do aluno">
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="Digite a data de nascimento do aluno">
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