<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

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
                $_SESSION['admin_username']  = $admin['username'];
                $_SESSION['admin_id']        = $admin['id'];
                header("Location: /DonaMart/admin/index.php");
                exit;
            } else {
                $error = 'Incorrect username or password.';
            }
        } catch (PDOException $e) {
            $error = 'Database error. Please try again.';
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
    <title>Admin Login – DonaMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --forest:      #1b4332;
            --forest-mid:  #2d6a4f;
            --forest-light:#52b788;
            --tan:         #b5835a;
            --cream:       #fcfaf5;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .login-wrap {
            width: 100%;
            max-width: 400px;
            padding: 16px;
        }

        /* Brand mark above card */
        .login-brand {
            text-align: center;
            margin-bottom: 24px;
        }
        .login-brand-icon {
            width: 52px; height: 52px;
            background: var(--forest);
            border-radius: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            color: var(--forest-light);
            font-size: 24px;
            margin-bottom: 10px;
        }
        .login-brand-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--forest);
            display: block;
        }
        .login-brand-sub {
            font-size: 12px;
            color: #999;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* Card */
        .login-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 16px;
            padding: 32px 28px;
        }

        /* Form labels */
        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        /* Input group */
        .input-group-text {
            background: #f8f8f6;
            border: 1px solid #e0e0e0;
            color: #aaa;
        }
        .form-control {
            border: 1px solid #e0e0e0;
            background: #f8f8f6;
            font-size: 14px;
            height: 42px;
        }
        .form-control:focus {
            background: #fff;
            border-color: var(--forest-mid);
            box-shadow: 0 0 0 3px rgba(45,106,79,0.12);
        }

        /* Submit button */
        .btn-login {
            background: var(--forest);
            color: #fff;
            border: none;
            width: 100%;
            height: 44px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-login:hover  { background: var(--forest-mid); }
        .btn-login:active { transform: scale(0.98); }

        /* Error */
        .login-error {
            background: #fcebeb;
            color: #a32d2d;
            border: 1px solid #f7c1c1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Back link */
        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
        .back-link a {
            color: #888;
            text-decoration: none;
        }
        .back-link a:hover { color: var(--forest); }

        /* Divider */
        .login-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 22px 0;
        }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="login-brand">
        <div class="login-brand-icon"><i class="fa-solid fa-leaf"></i></div>
        <span class="login-brand-name">DonaMart</span>
        <span class="login-brand-sub">Admin Portal</span>
    </div>

    <div class="login-card">

        <?php if (!empty($error)): ?>
        <div class="login-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" autocomplete="on">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user fa-sm"></i></span>
                    <input type="text" name="username" id="username"
                           class="form-control" placeholder="Enter username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock fa-sm"></i></span>
                    <input type="password" name="password" id="password"
                           class="form-control" placeholder="Enter password"
                           required>
                    <button type="button" class="input-group-text" style="cursor:pointer;"
                            onclick="togglePwd()" title="Show/hide password">
                        <i class="fa-solid fa-eye fa-sm" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Sign in
            </button>
        </form>

        <div class="login-divider"></div>

        <div class="back-link">
            <a href="/DonaMart/index.php">
                <i class="fa-solid fa-arrow-left fa-sm"></i> Back to website
            </a>
        </div>
    </div>

</div>

<script>
function togglePwd() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}
</script>
</body>
</html>