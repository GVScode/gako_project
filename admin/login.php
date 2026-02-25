<?php
require_once '../includes/config.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    $stmt = $pdo->prepare("
        SELECT id, nome, senha 
        FROM administradores 
        WHERE email = ?
    ");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($senha, $admin['senha'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nome'] = $admin['nome'];
        
        header('Location: dashboard.php');
        exit;
    } else {
        $erro = 'Email ou senha inválidos';
    }
}
?>