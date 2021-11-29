<?php
/***** LIGAR BASE DE DADOS *****/
$lnk = mysqli_connect("localhost", "samachadocom_user", "8ibm~m;q1KRo", "samachadocom_base")or die("Erro BD" . mysqli_error($lnk));
mysqli_set_charset($lnk, "utf8");
?>