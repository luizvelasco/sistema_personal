<?php

    require_once("globals.php");
    require_once("db.php");
    require_once ("models/Aluno.php");
    require_once ("models/Message.php");
    require_once ("dao/professorDAO.php");
    require_once ("dao/AlunoDAO.php");
    require_once ("dao/AvaliacaoDAO.php");

    $message = new Message($BASE_URL);
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $alunoDao = new AlunoDAO($conn, $BASE_URL);
    $avaliacaoDao = new AvaliacaoDAO($conn, $BASE_URL);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Busca o id do professor
     $professorData = $professorDao->verifyToken(true);
     $professor_id = $professorData->id;

    // Pega o ID do aluno via GET
    $aluno_id = filter_input(INPUT_GET, "aluno_id");
     
    if($type === "create") {
    
        // // Recebere os dados dos inputs
        $data_avaliacao = filter_input(INPUT_POST, "data_avaliacao");
        $data_avaliacao = str_replace("/", "-", $data_avaliacao); // converte para formato compatível
        $data_avaliacao = date("Y-m-d", strtotime($data_avaliacao)); // converte para formato DATE (YYYY-MM-DD)
        $peso = filter_input(INPUT_POST, "peso");
        $percentual_gordura = filter_input(INPUT_POST, "percentual_gordura");
        $percentual_massa_magra = filter_input(INPUT_POST, "percentual_massa_magra");
        $observacoes = filter_input(INPUT_POST, "observacoes");        

        $avaliacao = new Avaliacao();

        $avaliacao->data_avaliacao = $data_avaliacao;
        $avaliacao->peso = $peso;
        $avaliacao->percentual_gordura = $percentual_gordura;
        $avaliacao->percentual_massa_magra = $percentual_massa_magra;
        $avaliacao->observacoes = $observacoes;
        $avaliacao->aluno_id = $aluno_id;

        $avaliacaoDao->create($avaliacao);

    } elseif ($type === "update") {

        

    } elseif($type === "delete") {

         // Verifica se foi enviado via POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = filter_input(INPUT_POST, "id");

            if (!$id) {
                $message->setMessage("ID de avaliação inválido.", "error", "index.php");
                exit();
            }
        }
        // Exclui o aluno com verificação de vínculo
        $avaliacaoDao->destroy($id, $professor_id);
        
    }else {
        $message->setMessage("Informações inválidas", "error", "index.php");
        exit();
    }










    