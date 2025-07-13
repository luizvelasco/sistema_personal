<?php

    require_once("globals.php");
    require_once("db.php");
    require_once ("models/Aluno.php");
    require_once ("models/Message.php");
    require_once ("dao/professorDAO.php");
    require_once ("dao/AlunoDAO.php");

    $message = new Message($BASE_URL);
    $professorDao = new ProfessorDAO($conn, $BASE_URL);
    $alunoDao = new AlunoDAO($conn, $BASE_URL);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Busca o id do professor
     $professorData = $professorDao->verifyToken(true);
     $professor_id = $professorData->id;

    if($type === "create") {

        

        // Recebere os dados dos inputs
        $nome = filter_input(INPUT_POST, "nome");
        $email = filter_input(INPUT_POST, "email");
        $telefone = filter_input(INPUT_POST, "telefone");
        $data_nascimento = filter_input(INPUT_POST, "data_nascimento");
        $data_nascimento = str_replace("/", "-", $data_nascimento); // converte para formato compatível
        $data_nascimento = date("Y-m-d", strtotime($data_nascimento)); // converte para formato DATE (YYYY-MM-DD)
        $genero = filter_input(INPUT_POST, "genero");
        

        $aluno = new Aluno();

        // Validação mímina de dados

        if(!empty($nome) && !empty($email)) {

            $aluno->nome = $nome;
            $aluno->email = $email;
            $aluno->telefone = $telefone;
            $aluno->data_nascimento = $data_nascimento;
            $aluno->genero = $genero;
            $aluno->professor_id = $professorData->id;

            // Foto
            if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) {

                $foto = $_FILES["foto"];
                $allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
                $maxSize = 2 * 1024 * 1024; // 2MB
                

                if (!in_array($foto["type"], $allowedTypes)) {
                    $message->setMessage("Tipo de imagem inválido. Envie JPG ou PNG.", "error", "back");
                    exit();
                }

                if ($foto["size"] > $maxSize) {
                    $message->setMessage("Imagem muito grande. Envie até 2MB.", "error", "back");
                    exit();
                }
                
                // Gera nome único
                $imageName = uniqid() . "." . pathinfo($foto["name"], PATHINFO_EXTENSION);
                $destPath = "img/alunos/" . $imageName;

                move_uploaded_file($foto["tmp_name"], $destPath);

                // Deleta foto antiga se houver
                if (!empty($aluno->foto) && file_exists("img/alunos/" . $aluno->foto)) {
                    unlink("img/alunos/" . $aluno->foto);
                }

                $aluno->foto = $imageName;
            }

            $alunoDao->create($aluno);

        } else {
            $message->setMessage("Você precisa adicionar pelo menos: nome e  e-mail!", "error", "back");
        }


    } elseif ($type === "update") {

        // Dados do formulário
        $id = filter_input(INPUT_POST, "id");
        $nome = filter_input(INPUT_POST, "nome");
        $email = filter_input(INPUT_POST, "email");
        $telefone = filter_input(INPUT_POST, "telefone");
        $genero = filter_input(INPUT_POST, "genero");
        $ativo = filter_input(INPUT_POST, "ativo");
        $data_nascimento = filter_input(INPUT_POST, "data_nascimento");
        $data_nascimento = str_replace("/", "-", $data_nascimento); // converte para formato compatível
        $data_nascimento = date("Y-m-d", strtotime($data_nascimento)); // converte para formato DATE (YYYY-MM-DD)

        // Busca o aluno no banco com verificação de vínculo
        $aluno = $alunoDao->findById($id, $professor_id);

        if (!$aluno) {
            $message->setMessage("Processar: Aluno não encontrado ou acesso negado!", "error", "index.php");
            exit();
        }

        // Atualiza os dados
        $aluno->nome = $nome;
        $aluno->email = $email;
        $aluno->telefone = $telefone;
        $aluno->data_nascimento = $data_nascimento;
        $aluno->genero = $genero;
        $aluno->ativo = $ativo;
        $aluno->atualizado_em = date("Y-m-d H:i:s");

        // Foto
        if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) {

            $foto = $_FILES["foto"];
            $allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($foto["type"], $allowedTypes)) {
                $message->setMessage("Tipo de imagem inválido. Envie JPG ou PNG.", "error", "aluno_edit.php?id=$id");
                exit();
            }

            if ($foto["size"] > $maxSize) {
                $message->setMessage("Imagem muito grande. Envie até 2MB.", "error", "aluno_edit.php?id=$id");
                exit();
            }

            // Gera nome único
            $imageName = uniqid() . "." . pathinfo($foto["name"], PATHINFO_EXTENSION);
            $destPath = "img/alunos/" . $imageName;

            move_uploaded_file($foto["tmp_name"], $destPath);

            // Deleta foto antiga se houver
            if (!empty($aluno->foto) && file_exists("img/alunos/" . $aluno->foto)) {
                unlink("img/alunos/" . $aluno->foto);
            }

            $aluno->foto = $imageName;
        }

        // Salva no banco
        $alunoDao->update($aluno);

        $message->setMessage("Aluno atualizado com sucesso!", "success", "aluno_dashboard.php");

    }elseif($type === "delete") {
        // Verifica se foi enviado via POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = filter_input(INPUT_POST, "id");

            if (!$id) {
                $message->setMessage("ID do aluno inválido.", "error", "index.php");
                exit();
            }

            // Exclui o aluno com verificação de vínculo
            $alunoDao->destroy($id, $professor_id);

        }
    }else {
        $message->setMessage("Informações inválidas", "error", "index.php");
        exit();
    }










    