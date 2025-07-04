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


    } else {
        $message->setMessage("Informações inválidas", "error", "index.php");
    }