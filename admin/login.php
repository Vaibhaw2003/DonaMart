<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: /DonaMart/admin/index.php"); exit;
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
                header("Location: /DonaMart/admin/index.php"); exit;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{--forest:#1b4332;--forest-mid:#2d6a4f;--forest-light:#52b788;--tan:#b5835a;--cream:#fcfaf5}
body{
  font-family:'Segoe UI',system-ui,sans-serif;
  min-height:100vh;background:var(--cream);
  display:flex;align-items:center;justify-content:center;
  -webkit-font-smoothing:antialiased;
}

/* full-screen 2-col layout */
.login-wrap{
  display:flex;width:100%;min-height:100vh;
}

/* Left decorative panel */
.login-left{
  flex:1;background:var(--forest);
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:48px;position:relative;overflow:hidden;
}
.login-left::before{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 70% 70% at 50% 30%,rgba(82,183,136,0.12) 0%,transparent 70%);
}
.login-left-content{position:relative;z-index:1;text-align:center}
.login-left-icon{
  width:72px;height:72px;background:rgba(255,255,255,0.1);
  border-radius:20px;display:flex;align-items:center;justify-content:center;
  color:var(--forest-light);font-size:34px;margin:0 auto 24px;
}
.login-left h1{font-size:28px;font-weight:700;color:#fff;margin-bottom:10px}
.login-left p{color:rgba(255,255,255,0.55);font-size:14px;line-height:1.65;max-width:280px;margin:0 auto}
.login-trust{
  margin-top:40px;display:flex;flex-direction:column;gap:12px;
  width:100%;max-width:280px;
}
.login-trust-item{
  display:flex;align-items:center;gap:10px;
  background:rgba(255,255,255,0.07);border-radius:10px;padding:12px 16px;
  color:rgba(255,255,255,0.7);font-size:13px;
}
.login-trust-item i{color:var(--forest-light);font-size:16px;width:18px;text-align:center;}

/* Right form panel */
.login-right{
  width:420px;min-width:420px;
  background:#fff;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:48px 40px;
}
.login-brand{text-align:center;margin-bottom:32px}
.login-brand-ico{
  width:48px;height:48px;background:var(--forest);border-radius:12px;
  display:inline-flex;align-items:center;justify-content:center;
  color:var(--forest-light);font-size:22px;margin-bottom:12px;
}
.login-brand h2{font-size:20px;font-weight:700;color:#111;margin-bottom:2px}
.login-brand p{font-size:12px;color:#999;letter-spacing:0.06em;text-transform:uppercase}

.form-group{margin-bottom:16px;width:100%}
.form-label{display:block;font-size:11px;font-weight:700;color:#666;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px}
.input-wrap{
  display:flex;align-items:center;
  border:1.5px solid #e5e5e5;border-radius:9px;overflow:hidden;
  background:#fafaf8;transition:border-color 0.2s,box-shadow 0.2s;
}
.input-wrap:focus-within{
  border-color:var(--forest-mid);
  box-shadow:0 0 0 3px rgba(45,106,79,0.1);background:#fff;
}
.input-ico{
  width:40px;display:flex;align-items:center;justify-content:center;
  color:#bbb;font-size:15px;flex-shrink:0;
}
.input-wrap input{
  flex:1;border:none;background:transparent;
  padding:10px 12px 10px 0;font-size:14px;outline:none;
  color:#111;font-family:inherit;
}
.input-wrap .eye-btn{
  width:40px;display:flex;align-items:center;justify-content:center;
  color:#bbb;cursor:pointer;background:none;border:none;font-size:15px;
}
.input-wrap .eye-btn:hover{color:#888}

.login-btn{
  width:100%;background:var(--forest);color:#fff;border:none;
  padding:12px;border-radius:9px;font-size:14px;font-weight:700;
  cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
  font-family:inherit;transition:background 0.15s,transform 0.1s;margin-top:8px;
}
.login-btn:hover{background:var(--forest-mid)}
.login-btn:active{transform:scale(0.99)}

.error-box{
  background:#fcebeb;border:1px solid #f7c1c1;border-radius:8px;
  padding:10px 14px;font-size:13px;color:#a32d2d;
  display:flex;align-items:center;gap:8px;margin-bottom:16px;width:100%;
}

.divider{height:1px;background:#f0f0f0;margin:20px 0;width:100%}
.back-link{text-align:center;font-size:12px}
.back-link a{color:#aaa;text-decoration:none;transition:color 0.2s}
.back-link a:hover{color:var(--forest)}

@media(max-width:768px){
  .login-left{display:none}
  .login-right{width:100%;min-width:0;padding:40px 24px}
}
</style>
</head>
<body>

<div class="login-wrap">
  <!-- Left Panel -->
  <div class="login-left">
    <div class="login-left-content">
      <div class="login-left-icon"><i class="fa-solid fa-leaf"></i></div>
      <h1>DonaMart</h1>
      <p>Manage your eco-friendly tableware business from one powerful dashboard.</p>
      <div class="login-trust">
        <div class="login-trust-item"><i class="fa-solid fa-boxes-stacked"></i>Product & Category Management</div>
        <div class="login-trust-item"><i class="fa-solid fa-envelope-open-text"></i>Bulk Enquiries & Messages</div>
        <div class="login-trust-item"><i class="fa-solid fa-images"></i>Gallery & Media Uploads</div>
        <div class="login-trust-item"><i class="fa-solid fa-newspaper"></i>Newsletter Subscribers</div>
      </div>
    </div>
  </div>

  <!-- Right Form -->
  <div class="login-right">
    <div class="login-brand">
      <div class="login-brand-ico"><i class="fa-solid fa-leaf"></i></div>
      <h2>Welcome back</h2>
      <p>Admin Portal</p>
    </div>

    <?php if (!empty($error)): ?>
    <div class="error-box">
      <i class="fa-solid fa-circle-exclamation"></i>
      <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" style="width:100%">
      <div class="form-group">
        <label class="form-label">Username</label>
        <div class="input-wrap">
          <div class="input-ico"><i class="fa-solid fa-user"></i></div>
          <input type="text" name="username" placeholder="Enter username"
                 value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                 required autofocus>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-wrap">
          <div class="input-ico"><i class="fa-solid fa-lock"></i></div>
          <input type="password" name="password" id="pwdInput" placeholder="Enter password" required>
          <button type="button" class="eye-btn" onclick="togglePwd()" title="Show/hide">
            <i class="fa-solid fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="login-btn">
        <i class="fa-solid fa-right-to-bracket"></i> Sign In
      </button>
    </form>

    <div class="divider"></div>
    <div class="back-link">
      <a href="/DonaMart/index.php"><i class="fa-solid fa-arrow-left fa-sm"></i> Back to website</a>
    </div>
  </div>
</div>

<script>
function togglePwd(){
  const i=document.getElementById('pwdInput');
  const e=document.getElementById('eyeIcon');
  if(i.type==='password'){i.type='text';e.className='fa-solid fa-eye-slash';}
  else{i.type='password';e.className='fa-solid fa-eye';}
}
</script>
</body>
</html>