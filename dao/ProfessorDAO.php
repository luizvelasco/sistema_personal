<?php

    require_once("models/Professor.php");
    require_once("models/Message.php");

    class ProfessorDAO implements ProfessorDAOInterface{

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

        public function update(Professor $professor, $redirect = true){

            $stmt = $this->conn->prepare("UPDATE professores SET 
                nome = :nome,
                telefone = :telefone,
                email = :email,
                token = :token
                WHERE id = :id
            ");

            $stmt->bindParam(":nome", $professor->nome);
            $stmt->bindParam(":telefone", $professor->telefone);
            $stmt->bindParam(":email", $professor->email);
            $stmt->bindParam(":token", $professor->token);
            $stmt->bindParam(":id", $professor->id);

            $stmt->execute();

             if($redirect) {
                // redireciona para o perfl do professor
                $this->message->setMessage("Dados atualizados com sucesso", "success", "editprofile.php");
            }


        }

         public function setTokenToSession($token, $redirect = true) {

            // Salvar token na session
            $_SESSION["token"] = $token;
            if($redirect) {
                // redireciona para o perfl do usuário
                $this->message->setMessage("Seja bem vindo!", "success", "index.php");
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

         public function verifyToken($protected = false) {

            if (!empty($_SESSION["token"])){

                // Pega o token da session
                $token = $_SESSION["token"];

                $professor = $this->findByToken($token);

                if ($professor){
                    return $professor;
                } else if ($protected){

                    // redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar essa página", "error", "auth.php");
                }
            } else if ($protected) {
                
                 // redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar essa página", "error", "auth.php");
            }
            
        }

        public function findByToken($token) {

             if($token != ""){

                $stmt = $this->conn->prepare("SELECT * FROM professores WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $professor = $this->buildProfessor($data);

                    return $professor;

                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        public function destroyToken() {

            // Remove o token da session
            $_SESSION["token"] = "";

            // Redireciona e apreseta a mensagem de sucesso
            $this->message->setMessage("Voce fez o logout com sucesso", "success", "auth.php");

        }

        public function authenticateProfessor($email, $password) {

            $professor = $this->findByEmail($email);

            if ($professor) {
                // Checar se a senhas batem
                if (password_verify($password, $professor->password)) {

                    // Gerar um token e inserir na session
                    $token = $professor->generateToken();

                    $this->setTokenToSession($token, false);

                    // Atualizar tokeon no usuários
                    $professor->token = $token;

                    $this->update($professor, false);

                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

    }