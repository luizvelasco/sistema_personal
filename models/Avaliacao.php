<?php

    class Avaliacao {

        public $id;
        public $aluno_id;
        public $data_avaliacao;
        public $peso;
        public $percentual_gordura;
        public $percentual_massa_magra;
        public $observacoes;
        public $criado_em;
        public $atualizado_em;

    }

    interface AvaliacaoDAOInterface {

        public function buildAvaliacao($data);
        public function getAvaliacoes($aluno_id);

    }
