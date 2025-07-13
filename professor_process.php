<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/Professor.php");
    require_once("models/Message.php");
    require_once("dao/ProfessorDAO.php");

    $message = new Message($BASE_URL);

    $professorDao = new ProfessorDAO($conn, $BASE_URL);

    // Resgata o tipo de formulário
    $type = filter_input(INPUT_POST, "type");

    // Atualizar o professor
    if($type == "update") {

        // Resgata dados do professor
        $professorData = $professorDao->verifyToken();

        // Recebe dados do post
        $nome = filter_input(INPUT_POST, "nome");
        $email = filter_input(INPUT_POST, "email");
        $telefone = filter_input(INPUT_POST, "telefone");

        // Cria um novo objeto de professor
        $professor = new Professor();

        // Preencher os dados do professor
        $professorData->nome = $nome;
        $professorData->email = $email;
        $professorData->telefone = $telefone;

        $professorDao->update($professorData);


    } else if($type == "changepassword") {

        // Recebe dados do POST
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
       
        // Resgata dados do usuário
        $professorData = $professorDao->verifyToken();
        
        $id = $professorData->id;

        if($password == $confirmpassword){

            // Criar um novo objeto de usuário
            $professor = new Professor();

            $finalPassword = $professor->generatePassword(($password));

            $professor->password = $finalPassword;
            $professor->id = $id;

            $professorDao->changePassword($professor);

        } else {
            $message->setMessage("As senhas não são iguais", "error", "back");
        }

    } else {
        $message->setMessage("Informaçõe inválidas", "error", "login.php");
    }