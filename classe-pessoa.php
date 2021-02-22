<?php
class Pessoa
{
    private $pdo;
    //-----------CONEXAO COM O BANCO DE DADOS poo----------------
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com o banco de dados".$e->getMessage();
            exit();/* caso de erro no codigo para o sistema opcinonal */
        } catch (Exception $e) {
            echo "Erro generico:".$e->getMessage();
        }
    }
    // FUNCAO PARA BUSCAR DADOS E COLOCAR NA TELA DIREITA


    //------------- LISTAR DADOS-------------------//
    public function buscarDados()
    {
        $res = array();/* se o banco de dados estive vazio n vai dar nenhum erro ele retorna um array vazio*/
        $cmd = $this->pdo->query("SELECT * FROM pessoas ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);/* fetch_assoc serve pra economizar memoria */
        return $res;/* qeum solicitar a ação vai rotnar o $res q tem o array contido nele */
    }

    //------------------função cadastrar pessoas no banco de dados------------------//


    public function cadastrarPessoa($nome, $telefone, $email)
    {
        // antes de cadastrar verificar se ja tem o email cadastrado
        $cachorro = $this->pdo->prepare("SELECT id  from pessoas WHERE email = :e");
        $cachorro->bindValue(":e", $email);
        $cachorro->execute();
        if ($cachorro->rowCount() > 0) {//ele vai verificar se ja tem esse nome cadastrado no banco de dados
            return false;
        } else { //se o email nao estiver no banco de dados ele vai inserir as infaomacoes
            $cachorro = $this->pdo->prepare("INSERT INTO pessoas(nome, telefone, email) VALUES(:n, :t, :e)")  ;
            $cachorro->bindValue(":n", $nome);
            $cachorro->bindValue(":t", $telefone);
            $cachorro->bindValue(":e", $email);
            $cachorro->execute();
            return true;
        }
    }


    public function excluirPessoa($id)
    {
        $suan = $this->pdo->prepare("DELETE FROM pessoas WHERE id =:id");
        $suan->bindValue(":id", $id);
        $suan->execute();
    }

    //--------------------buscar dados de uma pessoa-----------------------
    public function buscarDadosPessoa($id)
    {
        $res = array();/* se n vier nada do banco de dados sera um array vazio, prevenção de erro */
        $cmd = $this->pdo->prepare("SELECT * FROM pessoas WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);/* como vai buscar só um registo(id) a gente usa fetch e se fosse mais de um usa fetchALL E fetch_assoc vai economizar dados */
        return $res;
    }
    //-------------------atualizar dados no banco de dados---------------------

    public function atualizarDados($id, $nome, $telefone, $email)
    {
        

            $cmd = $this->pdo->prepare("UPDATE pessoas SET nome =:n, telefone =:t, email = :e WHERE id = :id ");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
          
    }
}
?>