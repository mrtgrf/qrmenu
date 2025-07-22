<?php

class AuthMiddleware {
   public static function requireAuth() {
       $auth = new Auth();
       
       if (!$auth->isLoggedIn()) {
           header('Location: /admin/login');
           exit;
       }
       
       return $auth->getUser();
   }
   public static function requireRole($roles) {
       $auth = new Auth();
       
       if (!$auth->isLoggedIn()) {
           header('Location: /admin/login');
           exit;
       }
       
       if (!$auth->hasRole($roles)) {
           header('HTTP/1.0 403 Forbidden');
           die('Bu işlem için yetkiniz bulunmamaktadır.');
       }
       
       return $auth->getUser();
   }
   public static function requireAdmin() {
       return self::requireRole(['super_admin', 'admin']);
   }
   public static function requireSuperAdmin() {
       return self::requireRole('super_admin');
   }
   public static function requireAPIAuth() {
       $auth = new Auth();
       
       if (!$auth->isLoggedIn()) {
           http_response_code(401);
           echo json_encode(['error' => 'Unauthorized']);
           exit;
       }
       
       return $auth->getUser();
   }
   public static function validateCSRF() {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
           
           if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
               http_response_code(403);
               die('CSRF token geçersiz');
           }
       }
   }
}
<?php
function hashPassword($password) {
   return password_hash($password, PASSWORD_DEFAULT);
}
function verifyPassword($password, $hash) {
   return password_verify($password, $hash);
}
function generateToken($length = 32) {
   return bin2hex(random_bytes($length));
}
function generateCSRFToken() {
   if (!isset($_SESSION['csrf_token'])) {
       $_SESSION['csrf_token'] = generateToken(16);
   }
   return $_SESSION['csrf_token'];
}
function validateEmail($email) {
   return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
function cleanInput($input) {
   return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
function escapeString($string) {
   return addslashes($string);
}
function safeRedirect($url) {
   $allowedHosts = ['localhost', $_SERVER['HTTP_HOST']];
   $parsedUrl = parse_url($url);
   
   if (isset($parsedUrl['host']) && !in_array($parsedUrl['host'], $allowedHosts)) {
       $url = '/admin/dashboard';
   }
   
   header("Location: $url");
   exit;
}
function getClientIP() {
   $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
   
   foreach ($ipKeys as $key) {
       if (array_key_exists($key, $_SERVER) === true) {
           foreach (explode(',', $_SERVER[$key]) as $ip) {
               $ip = trim($ip);
               if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                   return $ip;
               }
           }
       }
   }
   
   return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}
function checkRateLimit($identifier, $maxAttempts = 5, $timeWindow = 300) {
   $key = "rate_limit_" . md5($identifier);
   
   if (!isset($_SESSION[$key])) {
       $_SESSION[$key] = ['count' => 0, 'time' => time()];
   }
   
   $data = $_SESSION[$key];
   if (time() - $data['time'] > $timeWindow) {
       $_SESSION[$key] = ['count' => 1, 'time' => time()];
       return true;
   }
   if ($data['count'] >= $maxAttempts) {
       return false;
   }
   $_SESSION[$key]['count']++;
   return true;
}
<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

$auth = new Auth();
if ($auth->isLoggedIn()) {
   safeRedirect('/admin/dashboard');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $username = cleanInput($_POST['username'] ?? '');
   $password = $_POST['password'] ?? '';
   $licenseKey = cleanInput($_POST['license_key'] ?? '');
   
   if (empty($username) || empty($password) || empty($licenseKey)) {
       $error = 'Tüm alanlar zorunludur';
   } else {
       $clientIP = getClientIP();
       if (!checkRateLimit($clientIP . '_login', 5, 900)) { // 15 dakikada 5 deneme
           $error = 'Çok fazla başarısız deneme. Lütfen daha sonra tekrar deneyin.';
       } else {
           $result = $auth->login($username, $password, $licenseKey);
           
           if ($result['success']) {
               safeRedirect('/admin/dashboard');
           } else {
               $error = $result['message'];
           }
       }
   }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Giriş</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
       body {
           background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
           min-height: 100vh;
           display: flex;
           align-items: center;
       }
       
       .login-container {
           background: white;
           border-radius: 10px;
           box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
           padding: 2rem;
           width: 100%;
           max-width: 400px;
       }
       
       .login-header {
           text-align: center;
           margin-bottom: 2rem;
       }
       
       .login-header h2 {
           color: #333;
           margin-bottom: 0.5rem;
       }
       
       .login-header p {
           color: #666;
           margin: 0;
       }
       
       .form-control {
           border-radius: 8px;
           padding: 12px;
           border: 1px solid #ddd;
       }
       
       .form-control:focus {
           border-color: #667eea;
           box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
       }
       
       .btn-primary {
           background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
           border: none;
           border-radius: 8px;
           padding: 12px;
           font-weight: 500;
       }
       
       .btn-primary:hover {
           transform: translateY(-1px);
           box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
       }
       
       .alert {
           border-radius: 8px;
           border: none;
       }
   </style>
</head>
<body>
   <div class="container">
       <div class="row justify-content-center">
           <div class="col-md-6">
               <div class="login-container">
                   <div class="login-header">
                       <h2>Admin Paneli</h2>
                       <p>Hesabınıza giriş yapın</p>
                   </div>
                   
                   <?php if ($error): ?>
                       <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                   <?php endif; ?>
                   
                   <?php if ($success): ?>
                       <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                   <?php endif; ?>
                   
                   <form method="POST" action="">
                       <div class="mb-3">
                           <label for="license_key" class="form-label">Lisans Anahtarı</label>
                           <input type="text" class="form-control" id="license_key" name="license_key" 
                                  value="<?= htmlspecialchars($_POST['license_key'] ?? '') ?>" required>
                       </div>
                       
                       <div class="mb-3">
                           <label for="username" class="form-label">Kullanıcı Adı / Email</label>
                           <input type="text" class="form-control" id="username" name="username" 
                                  value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                       </div>
                       
                       <div class="mb-3">
                           <label for="password" class="form-label">Şifre</label>
                           <input type="password" class="form-control" id="password" name="password" required>
                       </div>
                       
                       <div class="d-grid">
                           <button type="submit" class="btn btn-primary">Giriş Yap</button>
                       </div>
                   </form>
                   
                   <div class="text-center mt-3">
                       <small class="text-muted">
                           <a href="/admin/forgot-password" class="text-decoration-none">Şifremi Unuttum</a>
                       </small>
                   </div>
               </div>
           </div>
       </div>
   </div>
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
?>