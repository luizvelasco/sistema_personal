<?php

    require_once("templates/header.php");

    if($professorDao) {
        $professorDao->destroyToken();
    }