<?php

require_once('../../config.php');

if(isset($_SESSION["logado"])) 
{ 
    session_destroy();
    echo("<script language='javascript'>parent.window.location.href='../view/front/index.php' </script>");
    exit; 
} 