<!DOCTYPE html>
<html lang="en">
<?php
//Conexão com BD
require_once "../db/db_connect.php";
//Sessão
session_start();

if (!isset($_SESSION['logado'])) {
    header('Location: index.php');
}
$id = $_SESSION['id_usuario'];
$sql = "SELECT  * 
        FROM    usuarios
        WHERE   id = $id ";
//Variaves da conexão, query
$resultado = mysqli_query($connect, $sql);

//Converte o resultado em array e torna os dados utilizaveis
$dados = mysqli_fetch_array($resultado);
$usuario = $dados['nome'];
//Encerramento de conexão com o banco
mysqli_close($connect);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página restrita</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1><?php echo "Seja Bem-vindo " . $usuario; ?></h1>
    <a href="logout.php">Sair</a>
</body>

</html>