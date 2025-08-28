<?php
session_start();
require_once 'conexao.php';
require_once 'php/permissoes.php';

if(!isset($_SESSION['id_usuario'])){
  header("Location: index.php");
  exit();
}

// Obtendo o nome do perfil do usuário logado
$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";

$stmtPerfil = $pdo -> prepare($sqlPerfil);
$stmtPerfil -> bindParam(":id_perfil",$id_perfil);
$stmtPerfil -> execute();
$perfil = $stmtPerfil -> fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil['nome_perfil'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <!-- script para funcionar o menu dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <title>Home - Lego mania</title>
</head>
<body>
    
<div class="d-flex vh-100 bg-light">
 <!-- Sidebar -->
 <?php exibirMenu(); ?>


  <!-- Conteúdo principal -->
  <div class="flex-grow-1">
    <!-- Header -->
    <nav class="navbar navbar-light bg-white shadow-sm">
      <div class="container-fluid">
        <button class="btn btn-dark" id="menu-toggle"><i class="bi bi-list"></i></button>
        <span class="navbar-brand mb-0 h1">
          <!-- Contéudo que identifica as horas -->
          <small class="text-muted">Horário atual:</small>
          <span id="liveClock" class="badge bg-secondary"></span>
        </span>
      </div>
    </nav>

    <!-- Conteúdo -->
    <div class="p-4">
      <h3>Bem-vindo, <?php echo $_SESSION["usuario"];?>! <br>
          Perfil: <?php echo $nome_perfil;?>.
    </h3>
    </div>
  </div>
</div> 

<script>
  // Alternar exibição do menu
    document.getElementById("menu-toggle").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("d-none");
  });

  function updateClock() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('pt-BR');
      document.getElementById('liveClock').textContent = timeString;
  }
  setInterval(updateClock, 1000);
  updateClock(); // Inicializa imediatamente

</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>




