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

    // Restaga dados do usuário
     $professorData = $professorDao->verifyToken(true);

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

            // Upload da foto do aluno
            if(isset($_FILES["foto"]) && !empty($_FILES["foto"]["tmp_name"])){

                $foto = $_FILES["foto"];
                $fotoTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];


                // Checando tipo da foto
                if(in_array($foto["type"], $fotoTypes)) {

                    if (in_array($foto["type"], $jpgArray)) {
                        $fotoFile = imagecreatefromjpeg($foto["tmp_name"]);
                    } else {
                        $fotoFile = imagecreatefrompng($foto["tmp_name"]);
                    }

                    // Gerando o nome da imagem
                    $fotoName = $aluno->imageGenerateName();

                    // Jogando a imagem para a pasta
                    imagejpeg($fotoFile, "./img/alunos/" . $fotoName, 100);

                    $aluno->foto = $fotoName;

                } else {

                    $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
                    exit;

                }

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
        $data_nascimento = filter_input(INPUT_POST, "data_nascimento");
        $genero = filter_input(INPUT_POST, "genero");
        $ativo = filter_input(INPUT_POST, "ativo");

        // Busca o aluno no banco com verificação de vínculo
        $aluno = $alunoDao->findById($id, $professor_id);

        echo $id . " - " . $professor_id;

        if (!$aluno) {
            $message->setMessage("Aluno não encontrado ou acesso negado!", "error", "index.php");
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
                $message->setMessage("Tipo de imagem inválido. Envie JPG ou PNG.", "error", "editaraluno.php?id=$id");
                exit();
            }

            if ($foto["size"] > $maxSize) {
                $message->setMessage("Imagem muito grande. Envie até 2MB.", "error", "editaraluno.php?id=$id");
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

        $message->setMessage("Aluno atualizado com sucesso!", "success", "editaraluno.php?id=$id");

    } else {
        $message->setMessage("Informações inválidas", "error", "index.php");
    }










    