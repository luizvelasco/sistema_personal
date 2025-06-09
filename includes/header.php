<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Sistema de Alunos</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="Sistema de gerenciamento de alunos">
    <meta name="author" content="Seu Nome">
    
    <!-- Favicon -->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <!-- Scripts de inicialização -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ativa tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Marca item ativo na sidebar
            const currentPage = window.location.pathname.split('/').pop() || 'index.php';
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</head>
<body>
    <!-- Container Principal -->
    <div class="container-fluid">
        <div class="row flex-nowrap">
            
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header text-center">
                    <h2 class="mb-4">
                        <i class="fas fa-graduation-cap me-2"></i>
                        <span class="d-none d-lg-inline">Painel de Controle</span>
                    </h2>
                </div>
                
                <ul class="nav flex-column">
                    <!-- Seção Alunos -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#collapseAlunos" role="button">
                            <i class="fas fa-users"></i>
                            <span class="d-none d-lg-inline">Alunos Cadastrados</span>
                        </a>
                        <div class="collapse show" id="collapseAlunos">
                            <ul class="nav flex-column sub-menu ps-4">
                                <li class="nav-item">
                                    <a class="nav-link" href="alunos.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Visualizar alunos">
                                        <i class="fas fa-eye"></i>
                                        <span class="d-none d-lg-inline">Ver Aluno</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <!-- Novo Aluno -->
                    <li class="nav-item">
                        <a class="nav-link" href="novo-aluno.php">
                            <i class="fas fa-user-plus"></i>
                            <span class="d-none d-lg-inline">Novo Aluno</span>
                        </a>
                    </li>
                    
                    <!-- Calautar -->
                    <li class="nav-item">
                        <a class="nav-link" href="calautar.php">
                            <i class="fas fa-calculator"></i>
                            <span class="d-none d-lg-inline">Calautar</span>
                        </a>
                    </li>
                    
                    <!-- Relatórios -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#collapseRelatorios" role="button">
                            <i class="fas fa-chart-line"></i>
                            <span class="d-none d-lg-inline">Relatórios</span>
                        </a>
                        <div class="collapse" id="collapseRelatorios">
                            <ul class="nav flex-column sub-menu ps-4">
                                <li class="nav-item">
                                    <a class="nav-link" href="relatorios.php">
                                        <i class="fas fa-file-alt"></i>
                                        <span class="d-none d-lg-inline">Ver Relatórios</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <!-- Separador -->
                    <li class="nav-item my-3"></li>
                    
                    <!-- Configurações -->
                    <li class="nav-item">
                        <a class="nav-link" href="configuracoes.php">
                            <i class="fas fa-cog"></i>
                            <span class="d-none d-lg-inline">Configurações</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Conteúdo Principal -->
            <main class="col ps-md-2 pt-2 main-content">
                <div class="page-header pt-3 pb-2 mb-4 border-bottom">
                    <h1 id="page-title"><?php echo $pageTitle ?? 'Bem-vindo'; ?></h1>
                </div>
                <div class="container-fluid">