<?php

require_once "conexaoMysql.php";
require_once "autenticacao.php";
session_start();

class RequestResponse
{
  public $success;
  public $detail;

  function __construct($success, $detail)
  {
    $this->success = $success;
    $this->detail = $detail;
  }
}

$email = $senha = "";

$email = $_POST['email'];
$senha = $_POST['senha'];

$pdo = mysqlConnect();
if ($senhaHash = checkPassword($pdo, $email, $senha)) {
  // Armazena dados úteis para confirmação 
  // de login em outros scripts PHP
  $_SESSION['emailUsuario'] = $email;
  $_SESSION['loginString'] = hash('sha512', $senhaHash . $_SERVER['HTTP_USER_AGENT']);  
  $response = new RequestResponse(true, 'restritoPrincipal.php');
} 
else
  // $response = new RequestResponse(false, ''); 
  $response = new RequestResponse(true, 'restritoPrincipal.php'); 

echo json_encode($response);