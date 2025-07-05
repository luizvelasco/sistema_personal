<?php
    require_once("templates/header.php");

    require_once("dao/AlunoDAO.php");

    // DAO alunos
    $alunoDao = new AlunoDAO($conn, $BASE_URL);

    $alunos = $alunoDao->getAlunos(); 

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Alunos</h2>
        <div class="movies-container">
            <?php foreach($alunos as $aluno): ?>
                <?php require("templates/aluno_card.php") ?>
            <?php endforeach; ?>
        </div>
        
    </div>
    
<?php
    require_once("templates/footer.php");
?>