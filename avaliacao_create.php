<?php
    require_once("templates/header.php");
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar Avaliação</h1>
        <p class="page-description">Registre uma nova avaliação física para o aluno</p>
        <form action="<?= $BASE_URL ?>avaliacao_process.php" id="add-avaliacao-form" method="post">
            <input type="hidden" name="type" value="create">

            <div class="form-group">
                    <label for="aluno">Nome do Aluno</label>
                    <input type="text" class="form-control" id="nome" name="nome" disabled>
            </div>

            <div class="form-group">
                <label for="data_avaliacao">Data da Avaliação</label>
                <input type="text" class="form-control" name="data_avaliacao" id="data_avaliacao">
            </div>

            <div class="form-group">
                <label for="peso">Peso (kg)</label>
                <input type="text" class="form-control" name="peso" id="peso" placeholder="Digite o peso">
            </div>

            <div class="form-group">
                <label for="percentual_gordura">% Gordura Corporal</label>
                <input type="text" class="form-control" name="percentual_gordura" id="percentual_gordura" placeholder="Digite o percentual de gordura">
            </div>

            <div class="form-group">
                <label for="percentual_massa_magra">% Massa Magra</label>
                <input type="text" class="form-control" name="percentual_massa_magra" id="percentual_massa_magra" placeholder="Digite o percentual de massa magra">
            </div>

            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea class="form-control" name="observacoes" id="observacoes" rows="4" placeholder="Observações adicionais..."></textarea>
            </div>

            <input type="submit" class="btn card-btn" value="Adicionar Avaliação">
        </form>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>