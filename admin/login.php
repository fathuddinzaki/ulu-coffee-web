<?php
session_start();
require_once '../includes/functions.php';

if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = loginUser($email, $password);

    if ($user && $user['role'] === 'admin') {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Email/Password salah atau Anda bukan Admin!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ulu Coffe</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .admin-login-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
        }
        .admin-brand {
            text-align: center;
            margin-bottom: 30px;
        }
        .admin-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--primary);
            margin: 0;
        }
        .admin-brand p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .form-group label {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        .form-control {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }
        .form-control:focus {
            background: white;
            border-color: var(--primary);
        }
    </style>
</head>
<body>

<div class="admin-login-card">
    <div class="admin-brand">
        <h1>Ulu Coffe</h1>
        <p>Administrator Access</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger" style="margin-bottom: 20px; font-size: 0.9rem; padding: 10px 15px;">
            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Email Address</label>
            <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="admin@toko.com" required>
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
            Login to Dashboard
        </button>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="../index.php" style="color: var(--text-light); font-size: 0.85rem; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Ulu Coffe
            </a>
        </div>
    </form>
</div>

</body>
</html>
