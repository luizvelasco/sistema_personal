<?php
require_once("templates/header.php");
require_once("models/Message.php");

require_once("models/Aluno.php");
require_once("dao/AlunoDAO.php");

require_once("models/Professor.php");
require_once("dao/ProfessorDAO.php");

$professorDao = new ProfessorDAO($conn, $BASE_URL);
$professorData = $professorDao->verifyToken(true);
$professor_id = $professorData->id;

$alunoDao = new AlunoDAO($conn, $BASE_URL);

// Pega o ID via GET
$id = filter_input(INPUT_GET, "id");

if (!$id) {
    header("Location: index.php");
    exit();
}

// Busca o aluno com restrição por professor
$aluno = $alunoDao->findById($id, $professor_id);

if (!$aluno) {
    $message->setMessage("Aluno não encontrado ou acesso negado!", "error", "index.php");
    exit();
}
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-3 col-md-6 bg-light text-dark p-4 rounded">
        <h1 class="page-title text-center">Editar Aluno</h1>

        <form action="<?= $BASE_URL ?>aluno_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <input type="hidden" name="id" value="<?= $aluno->id ?>">

            <div class="form-group mb-3">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= $aluno->nome ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $aluno->email ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="form-control" value="<?= $aluno->telefone ?>">
            </div>

            <div class="form-group mb-3">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" value="<?= date("d/m/Y", strtotime($aluno->data_nascimento)) ?>" required>

            </div>

            <div class="form-group mb-3">
                <label for="genero">Gênero:</label>
                <select name="genero" id="genero" class="form-control" required>
                    <option value="">Selecione</option>
                    <option value="Masculino" <?= $aluno->genero == "Masculino" ? "selected" : "" ?>>Masculino</option>
                    <option value="Feminino" <?= $aluno->genero == "Feminino" ? "selected" : "" ?>>Feminino</option>
                    <option value="Outro" <?= $aluno->genero == "Outro" ? "selected" : "" ?>>Outro</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="ativo">Status:</label>
                <select name="ativo" id="ativo" class="form-control">
                    <option value="1" <?= $aluno->ativo ? "selected" : "" ?>>Ativo</option>
                    <option value="0" <?= !$aluno->ativo ? "selected" : "" ?>>Inativo</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="foto">Foto:</label>
                <?php if ($aluno->foto): ?>
                    <div class="mb-2">
                        <img src="<?= $BASE_URL ?>img/alunos/<?= $aluno->foto ?>" alt="<?= $aluno->nome ?>" style="max-width: 150px;" class="img-thumbnail">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>

            <input type="submit" class="btn btn-primary w-100" value="Salvar Alterações">
        </form>

        <div class="mt-3 text-center">
            <a href="<?= $BASE_URL ?>index.php" class="btn btn-light">Cancelar</a>
        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>
