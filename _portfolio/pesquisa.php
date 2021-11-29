<?php
include('../_connect.php');
session_start();

if (isset($_POST['pesquisa'])){ $pesquisa=ltrim($_POST['pesquisa']); }
if (isset($_POST['inicio'])){ $inicio=$_POST['inicio']; }
if (isset($_POST['fim'])){ $fim=$_POST['fim']; }
if (isset($_POST['id_pais'])){ $id_pais=$_POST['id_pais']; }
if (isset($_POST['categoria'])){ $categoria=$_POST['categoria']; }

include('fichas.php');
?>