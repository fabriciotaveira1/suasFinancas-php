<?php
// Variável para armazenar mensagens de erro
$erro = '';

session_start();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclui o arquivo de conexão
    require_once '../../../../modelo/conexao.php';
    require_once '../../../../modelo/Usuario.php';
    require_once '../../../../modelo/Despesas.php';


    // Captura os dados do formulário
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $dataDespesa = $_POST['dataDespesa'];
    $status = $_POST['status'];
    $userID = $_SESSION['UserID']; //UserID na sessão



    // Instancia a classe Despesa com a conexão
    $despesaModel = new Despesas($conn);
    $usuarioModel = new Usuario($conn);



    // Chama o método para inserir um novo usuário
    $inserido = $despesaModel->inserirDespesa($userID, $descricao, $valor, $categoria, $dataDespesa, $status);



    if ($inserido) {
        // Redireciona ou executa outra ação após o cadastro

        //Chama o método para ver as despesas
        $despesas = $despesaModel->verDespesas($userID);

        //busca os dados das tabelas para o dashboard
        $despesasDashboard = $usuarioModel->buscarDados($_SESSION['UserID'], 'Despesas');
        $metasDashboard = $usuarioModel->buscarDados($_SESSION['UserID'], 'Metas');
        $pagamentosDashboard = $usuarioModel->buscarDados($_SESSION['UserID'], 'Pagamentos');

        // Armazenar as vaariáveis na sessão
        $_SESSION['despesas'] = $despesas;
        $_SESSION['despesasDashboard'] = $despesasDashboard;
        $_SESSION['metasDashboard'] = $metasDashboard;
        $_SESSION['pagamentosDashboard'] = $pagamentosDashboard;

        echo "<script>
                alert('Despesa inserida com sucesso.');
                window.location.href = '../../usuario/despesas.php';
              </script>";
        exit;
    } else {
        $erro = "Erro ao cadastrar despesa. Por favor, tente novamente mais tarde.";
        echo "<script>alert('$erro');
            window.location.href = '../../usuario/despesas.php';
              </script>";
        exit;
    }
}
?>