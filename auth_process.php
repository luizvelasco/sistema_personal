<?php

    require_once("globals.php");
    require_once("db.php");
    require_once ("models/Professor.php");
    require_once ("models/Message.php");
    require_once ("dao/ProfressorDAO.php");

    $message = new Message($BASE_URL);

    $professorDao = new ProfressorDAO($conn, $BASE_URL);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Verificação do tipo de formulário
    if ($type === "register") {

        $nome = filter_input(INPUT_POST, "nome");
        $telefone = filter_input(INPUT_POST, "telefone");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // VErificação de dados mínimos
        if ($nome && $telefone && $email && $password) {

            // Verificar se as senhas são iguais
            if ($password === $confirmpassword) {

                // Verificar se o e-mail já está cadastrado no sistema
                if($professorDao->findByEmail($email) == false){

                   // Criação de senha e token
                    $professorToken = $professor->generateToken();
                    $finalPassword = $professor->generatePassword($password);

                    $professor->nome = $nome;
                    $professor->telefone = $telefone;
                    $professor->email = $email;
                    $professor->password = $finalPassword;
                    $professor->token = $professorToken;

                    $auth = true;

                    $professorDao->create($user,$auth);

                } else {
                    // Enviar msg de erro, usuáriuo já existe
                    $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");
                }

            } else {
                // Enviar msg de erro, de senhas não batem
                $message->setMessage("As senhas não são iguais.", "error", "back");
            }


        } else {

            // Enviar msg de erro, de dados faltantes
            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");

        }

    } else if ($type === "login") {

    }