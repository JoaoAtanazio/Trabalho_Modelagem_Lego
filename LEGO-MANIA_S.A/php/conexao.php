<?php
// Configurações para a conexão com o banco de dados

// $host: Define o endereço do servidor onde o banco de dados está hospedado.
$host = 'localhost';

// $dbname: Define o nome do banco de dados ao qual queremos nos conectar.
$bdnome = 'bd_legomania';

// $user: Define o nome de usuário para acessar o banco de dados.
$user = 'root';

// $pass: Define a senha para o usuário do banco de dados.
$senha = '';

// Se algo der errado ao tentar conectar ao banco de dados (dentro do 'try'),
// o código dentro do 'catch' será executado para lidar com o erro de forma controlada.
try {
    // Tenta criar uma nova conexão com o banco de dados usando PDO.

    // "mysql:host=$host;dbname=$dbname" é o DSN (Data Source Name).
    $pdo = new PDO("mysql:host=$host;bdnome=$dbname", $user, $senha);

    // Configura o PDO para lançar exceções em caso de erros.
    // PDO::ATTR_ERRMODE: Define o modo de relatório de erros.
    // PDO::ERRMODE_EXCEPTION: Se ocorrer um erro na comunicação com o banco (ex: consulta SQL errada),
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Se ocorrer qualquer erro (uma PDOException) durante a tentativa de conexão no bloco 'try',
    // die() interrompe a execução do script e exibe uma mensagem.
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>