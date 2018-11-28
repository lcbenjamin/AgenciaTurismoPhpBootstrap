<?php 
// Verifica se existe os dados da sessão de login 
if(!isset($_SESSION["logado"])) 
{ 
    echo("<script language='javascript'>parent.window.location.href='login.php' </script>");
    exit; 
} 
?>