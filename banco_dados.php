<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
<?php
//--------------CONEXAO COM BANCO DE DAOS--------------------
try {
    $pdo = new PDO("mysql:dbname=pdo;host=localhost","root","");
} catch (Exception $e) {
    echo "Erro com banco de dados".$e->getMessage();
}catch(Exception $e){
    echo "Erro generico".$e->getMessage();
}

//----------------------------------INSERT------------------------------//
$res=$pdo->query("INSERT INTO pessoas(nome,telefone,email)VALUES('mariam','0000000000000000','teste@gmail.com')");



//----------------------------------DELETE-----------------------------//
$res=$pdo->query("DELETE FROM pessoas WHERE id='2'");


//------------------------------UPDATE-----------------------------//

$res = $pdo->query("UPDATE pessoas SET email = 'paulo2@gmail.com' WHERE id = '4'");

//--------------------------SELECT-----------------//
$res = $pdo->prepare("SELECT * FROM pessoas WHERE id=:id");
$res->bindValue(":id",4);
$res->execute();
$resultado = $res->fetch(PDO::FETCH_ASSOC);
foreach($resultado as $key =>$value){
    echo $key.": ".$value."<br>";
}
?>




</body>
</html>