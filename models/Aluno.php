<?php

    class Aluno {

        public $id;
        public $nome;
        public $email;
        public $telefone;
        public $data_nascimento;
        public $genero;
        public $foto;
        public $ativo;
        public $professor_id;

        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
        }

    }

    interface AlunoDAOInterface {

        public function buildAluno($data);
        public function getAlunos($professor_id);
        public function findAll();
        public function create(Aluno $aluno);
        public function update(Aluno $aluno);
        public function destroy ($id);
    }
