<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: /DonaMart/admin/index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_id'] = $admin['id'];
                
                header("Location: /DonaMart/admin/index.php");
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } catch (PDOException $e) {
            $error = 'Database connection error. Please try again.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - DonaMart</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1b4332;
            --accent-color: #b5835a;
        }
        body {
            background-color: #fcfaf5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }
        .login-header {
            background-color: var(--primary-color);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px 30px;
            background-color: white;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #143224;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h3 class="mb-0 font-weight-bold"><i class="fa-solid fa-leaf me-2 text-success"></i>DonaMart Admin</h3>
        <p class="text-white-50 mb-0 mt-1">Please enter your credentials to login</p>
    </div>
    <div class="login-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa-solid fa-circle-exclaim me-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label font-weight-bold text-sm text-dark">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                    <input type="text" name="username" id="username" class="form-control bg-light border-start-0" placeholder="Username" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label font-weight-bold text-sm text-dark">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" name="password" id="password" class="form-control bg-light border-start-0" placeholder="Password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 py-2.5 rounded-pill font-weight-bold shadow-md">Sign In</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="/DonaMart/index.php" class="text-decoration-none text-muted text-sm"><i class="fa-solid fa-arrow-left me-1"></i> Back to Website</a>
        </div>
    </div>
</div>

</body>
</html>
