<!DOCTYPE html>
<?php

require_once "../db/db_connect.php";
//sessão
session_start();

$erros = [];
if (isset($_POST['entrar'])) {
    $login = mysqli_escape_string($connect, $_POST['login']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);

    if (empty($login) or empty($senha)) {
        $erros[] = "<li>Preencha email e senha para prosseguir</li>";
    } else {

        $sql = "    SELECT  login 
                    FROM    usuarios
                    WHERE   login = '$login'";
        $resultado = mysqli_query($connect, $sql);

        //Verifica se consta algum registro nessa busca
        if (mysqli_num_rows($resultado) > 0) {
            $senha = md5($senha);
            $sql = "SELECT  * 
                    FROM    usuarios
                    WHERE   login = '$login' 
                    AND     senha = '$senha'";
            //Variaves da conexão, query
            $resultado = mysqli_query($connect, $sql);
            if (mysqli_num_rows($resultado) == 1) {
                //Converte o resultado em array e torna os dados utilizaveis
                $dados = mysqli_fetch_array($resultado);
                //Encerramento de conexão com o banco
                mysqli_close($connect);
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: home.php');
            } else {
                $erros[] = "<li>Usuário e senha não confere</li>";
            }
        } else {
            $erros[] = "<li>Usuário inexistente</li>";
        }
    }
}

?>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>LOGIN</title>
</head>

<body>
    <h1>Login</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="info">
        <label class="form-label">Login: </label>
        <input class="form-control" type="email" name="login" id="login">
        <label class="form-label">Senha: </label>
        <input class="form-control" type="password" name="senha" id="senha">
        <button type="submit" name="entrar">Entrar</button>
        </div>
        <div>
            <?php
            if (count($erros) > 0) { {
                    foreach ($erros as $erro) {
                        echo $erro;
                    }
                }
            } ?>
        </div>
    </form>
</body>

</html>