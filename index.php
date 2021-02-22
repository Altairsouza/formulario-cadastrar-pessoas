<?php

require_once 'classe-pessoa.php'; //<!-- to fazendo a ligacao com index.php e classe-pessoa.php (classe-pessoa.php) -->
$p = new Pessoa("pdo","localhost","root","");// <!-- a variavel p é por escolha -->
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
<?php //esse php esta ligando os input a lista quando digitar no input as informacoes vai pra lista 

if(isset($_POST['nome']))  {      // se existe o array $_post. (no form vai ver se existe aquele formulario) vc vai escolha uns dos name na tag input do seu cadastro . ele vai verificar se a pessoa clicou em cadastrar e se no $_POST[ 'nome'( ta pegando da tag input no cadastro) se ele existir vai da sequencia no programa OU A PESSOA CICLOU NO BOTAO EDITAR]-->


    //===============----------EDITAR---------------
    if (isset($_GET['id_up']) && !empty($_GET['id_up'])) { /* configuração para editar o botão (EDITAR) ISSET PARA VER SE EXISTE JÁ ESSE ID PARA EDITAR E EMPTY PARA RELAMENTE VER SE ESSA VARIAVEL NAO ESTÁ FAZIA*/


        $id_upd = addslashes($_GET['id_up']);
        $nome = addslashes($_POST['nome']);// addslashes(addslashes esse é o verdadeiro pq tem varios nomes parecidos) nao vai deixar ninguem degitar algo maliciosa nas caixinhas do input
        $telefone = addslashes($_POST['telefone']);
        $email =  addslashes($_POST['email']);
        if (!empty($nome) && !empty($telefone) && !empty($email)) {   //empty serve pra verificar se nao estiver vazio a variavel nome telefone e email ai nos podemos enviar para cadastrar, caso contrario a pessoa deixou de cadastrar algo caixa do input
        
            //Editar continuação do botao editar
             $p->atualizarDados($id_upd, $nome, $telefone, $email); //se a função voltar verdadeira é pq a pessoa foi cadastrada
                
             header("location: index.php"); /* ele vai da um f5 na pagina */
            
        }else {

            ?>
            <div id="n">
                <img src="_imagens/aviso.jpg">
                <h4>Preencha todos os campos!</h4>
            </div>
            
            <?php
        }
        //==========CADASTRAR-=================
    } else {   /* se nao for editar ele vai automaticamente cadastrar */


        
        $nome = addslashes($_POST['nome']);// addslashes(addslashes esse é o verdadeiro pq tem varios nomes parecidos) nao vai deixar ninguem degitar algo maliciosa nas caixinhas do input
        $telefone = addslashes($_POST['telefone']);
        $email =  addslashes($_POST['email']);
        if (!empty($nome) && !empty($telefone) && !empty($email)) {   //empty serve pra verificar se nao estiver vazio a variavel nome telefone e email ai nos podemos enviar para cadastrar, caso contrario a pessoa deixou de cadastrar algo caixa do input
    
            //Editar continuação do botao editar
        if (!$p->cadastrarPessoa( $nome, $telefone, $email)) {//se a função voltar verdadeira é pq a pessoa foi cadastrada
           
            ?>
            <div id="n">
                <img src="_imagens/aviso.jpg">
                <h4>Email já está cadastrado!</h4>
            </div>
            
            <?php
            
        }
        
        } else {
            ?>
            <div id="n">
                <img src="_imagens/aviso.jpg">                 
                <h4>Preencha todos os campos!</h4>
            </div>
            
            <?php
        }
    }
}
     ?>

<?php //ele vai verificar se a pessoa ciclou no botão editar(vai pra parte de editar mais ou menos linha 17)
    if (isset($_GET['id_up'])) /* isset(se existe) a variavel $GET['id'] */
    {
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    } ?>





    <section  id="esquerda">
        <form  method="POST">
            <h2>CADASTRO DE PESSOAS</h2>
                <label for="tn">Nome</label>
                <input type="text" name="nome" id="nome"
                value="<?php if (isset($res)) {
        echo $res['nome'];
    } ?>"><!-- continuando a configuração do botão editar ele vai verificar isset(se existe) a variavel $res é pq a pessoa clicou no botao editar e nao precisar colocar o else pq se for falsa ela nem vai entrar nesse bloco vai colocar em todos os input -->

                <label for="tt">Telefone</label>
                <input type="number" name="telefone" id="telefone"
                value="<?php if (isset($res)) {
        echo $res['telefone'];
    } ?>">
                <label for="te">Email</label>
                <input type="email" name="email" id="email"
                value="<?php if (isset($res)) {
        echo $res['email'];
    } ?>">
                <input type="submit"
                 value="<?php if (isset($res)) {
        echo "Atualizar";                                                    
    } else {
        echo "Cadastrar";
    } ?>"> <!-- agora tem duas opção quando apaerta no botao editar, e se tudo occorer bem ao inves de cadastrar ele vai atualizar as informacoes -->
                


        </form>


    </section>
    <section id="direita">
    <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <td colspan="3">Email</td>
            

            </tr>
        <?php
       $dados=  $p->buscarDados();/* to buscando o metodo q eu crirei na classe-pessoa. php para mostrar o array no index na parte direita q vai mostra a lista(array) agora estar tudo quardado no $dados */
       
    if (count($dados)>0) {/* ele vai verificar se o array nao esta vazio pra não da erro ele passou pelo for e por foreach pq o primeiro é pra array simplies e o outro pra array grande

        * count serve para verificar o tamanho dos dados */
        
        for ($i=0;$i<count($dados);$i++) {
            echo "<tr>";

            foreach ($dados[$i] as $key => $value) {
                if ($key !="id") {/* aqui ele nao vai mostrar o id na coluna pq o array ta buscando  tudo e aqui nao preciso do id */
                    echo "<td>".$value."</td>";
                }
            } ?>
               <td>
                  
                   <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a><!-- aqui está id_up pra nao fica igual com o id excluir logo na linha a baixo -->



                <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a></td> <!--   ao inves de colocar o echo eu abri e fechei php fora das td       href(configurando para excluir  o id selecionado quando aperta em exlcuir e aqui abri e fechei php(fui buscar a variavel #dados q contem o id para ser excluido) )-->
                <?php
                echo "</tr>";
        }
    } else {
        ?>
        </table>
        
        <div id="n">
            <h4>Ainda não há pessoas cadastradas!</h4>
        </div>
        
        <?php
    } 
    ?>


    </section>
</body>
</html>

<!-- condigo usado para exluir a pagina -->

<?php
if (isset($_GET['id'])) { /* ISSET(SE A VARIAVEL EXISTE) A VARIAVEL ID SE ELA EXISTI VOU COLOCAR ELA DENTRO DE UMA VARIAVEL     esse metodo tem q ser $_GET*/
        $id_pessoa = addslashes($_GET['id']);  /* CRIEI A VARIVEL $id_pessoa para armazena a variavel id q for se excluida e addslashes serve como protencao*/
        $p->excluirPessoa($id_pessoa);/* to pegando o metodo excluir pessoa em CLASSE-PESSOA.PHP    e salvando em $p */
        header("location: index.php");/* depois de ter excluido o id ele vai atualizar a pagina */
        exit();
    }


?>