<?php

$link = mysqli_connect("localhost", "root", "", "desafio_daniel");


if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
   
$msg = false; 

if(isset($_FILES['arquivo'])){ //Estrutura para verificar se o arquivo foi enviado.
    $arquivo = $_FILES['arquivo']['name']; //recuperar nome do arquivo.
    
    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)); //função para receber a extensão do arquivo "PATHINFO".
               // strtolower função PHP para padronizar as extensões dos arquivos. ex: .jpg .png .webm
    
    $novo_nome = md5(time()).".".$extensao; //criar novo nome para o arquivo, com uma função "time" mais um parametro para adicionar a extensão.
    // função para criptografar alguma string ou parametro, evitando duplicidade.
      

    $diretorio = "upload/"; //criando diretório onde as imagens serão salvas.

    
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome); 
    //função para upload dos arquivos, com parametro para salvar os arquivos no diretório concatenado com seu novo nome. 
    
    $sql_code = "INSERT INTO arquivo(id, arquivo, data) VALUES('','$novo_nome', NOW())";
    //inserção de dados no banco com uma função do "MySQL" para registrar a hora de envio.
    
    if(mysqli_query($link, $sql_code)) //verifica se o arquivo foi enviado.
        $msg = "Arquivo enviado com sucesso!";
    else
        $msg = "Falha ao enviar arquivo!";
}
$sql_busca = "SELECT * FROM arquivo"; //função de busca de arquivos no banco.
$mostrar = mysqli_query($link, $sql_busca); // recebe a query do banco e mostra os arquivos registrados no banco.

<html>
    <head lang="pt-br">
        <title>Desafio Daniel : Upload de Imagens com PHP + MySQL</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        <h1>Desafio Daniel</h1>
        <h3>Upload de Imagens com PHP e MySQL</h3>
        <br />
        <h6>Imagens:</h6>
        

            <?php
            while($dados = mysqli_fetch_array($mostrar)){ //estrutura de repetição para mostrar as imagens
               $arquivo = $dados['arquivo']; 
            ?>
            <img src="upload/<?=$arquivo?>" />
            <?php }?> //enquanto houver dados irá mostrar as imagens.

        
        <?php 
        if(isset($msg) && $msg != false){ //se a condição for verdadeira, mostrar variavel $msg.
            echo "<p>$msg</p>";
        }
        ?>
        <br />
        <form action="index.php" method="post" enctype="multipart/form-data">
            Selecione o arquivo: <input type="file" name="arquivo"/>
            <input type="submit" value="Enviar"/>
        </form>

    </body>
</html>