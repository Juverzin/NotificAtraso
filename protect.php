<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['nome'])){
    die("Você não pode acessar essa pagina porque não esta logado.");
}

?>