<?php
    if(empty($aluno->foto)) {
        $aluno->foto = "aluno.png";
    }
?>

<div class="card movie-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/alunos/<?= $aluno->foto ?>')"></div>
    
    <div class="card-body">
        <h5 class="card-title">
            <a href="<?= $BASE_URL ?>aluno.php?id=<?= $aluno->id ?>"><?= htmlspecialchars($aluno->nome) ?></a>
        </h5>

        <p class="card-text">
            <?= htmlspecialchars($aluno->email) ?><br>
            <?= htmlspecialchars($aluno->telefone) ?><br>
            <?= date('d/m/Y', strtotime($aluno->data_nascimento)) ?>
        </p>

        <a href="<?= $BASE_URL ?>aluno.php?id=<?= $aluno->id ?>" class="btn btn-primary rate-btn">Avaliações</a>
        <a href="<?= $BASE_URL ?>aluno.php?id=<?= $aluno->id ?>" class="btn btn-primary card-btn">Editar</a>
    </div>
</div>
