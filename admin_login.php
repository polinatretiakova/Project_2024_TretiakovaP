<?php
session_start();

$correct_password = "admin123"; 

if (isset($_POST['password'])) {
    if ($_POST['password'] === $correct_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Неверный пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #1a1a1a;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .login-box {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        background: #2a2a2a;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
        border-top: 3px solid #df0e62;
    }
    .login-box h2 {
        color: #fff;
        margin-bottom: 25px;
    }
    .form-control {
        background-color: #333;
        border-color: #555;
        color: #eee;
        padding: 12px;
    }
    .form-control:focus {
        background-color: #444;
        border-color: #df0e62;
        box-shadow: 0 0 0 0.25rem rgba(223, 14, 98, 0.25);
        color: #eee;
    }
    .btn-primary {
        background-color: #df0e62;
        border-color: #df0e62;
        padding: 10px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #c00d56;
        border-color: #c00d56;
        transform: translateY(-2px);
    }
    .alert {
        border-radius: 4px;
    }
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.2);
        border-color: rgba(220, 53, 69, 0.3);
        color: #dc3545;
    }
    .form-label {
        color: #dc3545;
    }
</style>
</head>
<body>
    <div class="login-box">
        <h2 class="text-center mb-4"><i class="bi bi-shield-lock"></i> Вход в админ-панель</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>