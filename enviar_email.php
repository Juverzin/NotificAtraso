<?php
function enviarEmail($para, $assunto, $mensagem) {
    $headers = "From: notificacao@iffar.edu.br\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($para, $assunto, $mensagem, $headers)) {
        return true;
    } else {
        return false;
    }
}
?>
