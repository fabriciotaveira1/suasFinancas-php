<?php
// Variável para armazenar mensagens de erro
$erro = '';

session_start();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclui o arquivo de conexão
    require_once '../../../../modelo/conexao.php';
    require_once '../../../../modelo/Despesas.php';


    // Captura os dados do formulário
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $dataDespesa = $_POST['dataDespesa'];
    $status = $_POST['status'];
    $userID = $_SESSION['UserID']; //UserID na sessão
    $despesaID = $_POST['DespesaID'];



    // Instancia a classe Despesa com a conexão
    $despesaModel = new Despesas($conn);



    // Chama o método para inserir um novo usuário
    $atualizado = $despesaModel->atualizarDespesa($userID,$despesaID, $descricao, $valor, $categoria, $dataDespesa, $status);



    if ($atualizado) {
        // Redireciona ou executa outra ação após o cadastro

        //Chama o método para ver as despesas
        $despesas = $despesaModel->verDespesas($userID);

        // Armazenar as despesas na sessão
        $_SESSION['despesas'] = $despesas;


        echo "<script>
                alert('Despesa atualizada com sucesso.');
                window.location.href = '../../usuario/despesas.php';
              </script>";
        exit;
    } else {
        $erro = "Erro ao atualizar despesa. Por favor, tente novamente mais tarde.";
        echo "<script>alert('$erro');
            window.location.href = '../../usuario/despesas.php';
              </script>";
        exit;
    }
}
?>