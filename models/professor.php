<?php

class Professor {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $password;
    public $token;
    public $ativo;

}

interface ProfessorDAOInterface {

    public function buildProfessor($data);
    public function create(Professor $professor, $authProfessor = false);

}
