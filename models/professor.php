<?php

class Professor {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $password;
    public $token;
    public $ativo;

     public function generateToken(){
        return bin2hex(random_bytes(50));
    }

    public function generatePassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

}

interface ProfessorDAOInterface {

    public function buildProfessor($data);
    public function create(Professor $professor, $authProfessor = false);
    public function findByEmail($email);

}
