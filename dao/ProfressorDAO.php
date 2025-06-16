<?php

    require_once("models/Professor.php");
    require_once("models/Message.php");

    class ProfressorDAO implements ProfessorDAOInterface{

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildProfessor($data){

            $professor = new Professor();

            $professor->id = $data["id"];
            $professor->nome = $data["nome"];
            $professor->email = $data["email"];
            $professor->telefone = $data["telefone"];
            $professor->password = $data["password"];
            $professor->token = $data["token"];
            $professor->ativo = $data["ativo"];

            return $professor;

        }
        public function create(Professor $professor, $authProfessor = false) {

            $stmt = $this->conn->prepare("INSERT INTO professores (
                nome, email, telefone, password, token) 
                VALUES (:nome, :email, :telefone, :password, :token)
            ");

            $stmt->bindParam(":nome", $professor->nome);
            $stmt->bindParam(":email", $professor->email);
            $stmt->bindParam(":telefone", $professor->telefone);
            $stmt->bindParam(":password", $professor->password);
            $stmt->bindParam(":token", $professor->token);

            $stmt->execute();

            // Autenticar usuário, caso auth seja true
            if ($authProfessor) {
                $this->setTokenToSession($professor->token);
            }

        }

         public function setTokenToSession($token, $redirect = true) {

            // Salvar token na session
            $_SESSION["token"] = $token;
            if($redirect) {
                // redireciona para o perfl do usuário
                $this->message->setMessage("Seja bem vindo!", "sucess", "editprofile.php");
            }

        }

        public function findByEmail($email) {

            if($email != ""){

                $stmt = $this->conn->prepare("SELECT * FROM professores WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildProfessor($data);

                    return $user;

                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

    }