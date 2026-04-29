<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

if (currentUser()) {
    redirect('index.php');
}

$errors = ['login' => '', 'register' => ''];
$activeTab = 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $activeTab = 'register';
        $firstName = trim((string) ($_POST['first_name'] ?? ''));
        $lastName = trim((string) ($_POST['last_name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if ($firstName === '' || $lastName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            $errors['register'] = 'Veuillez remplir correctement tous les champs (mot de passe min. 8 caractères).';
        } else {
            $stmt = db()->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $errors['register'] = 'Cet email existe déjà.';
            } else {
                $insert = db()->prepare(
                    'INSERT INTO users (first_name, last_name, email, password_hash) VALUES (:first_name, :last_name, :email, :password_hash)'
                );
                $insert->execute([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ]);
                $errors['register'] = 'Compte créé. Vous pouvez vous connecter.';
                $activeTab = 'login';
            }
        }
    }

    if ($action === 'login') {
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $errors['login'] = 'Identifiants invalides.';
        } else {
            $stmt = db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors['login'] = 'Email ou mot de passe incorrect.';
            } else {
                loginUser($user);
                redirect('index.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LUMIO — Connexion</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="auth-page">
  <header class="site-header">
    <div class="container header-inner">
      <a href="index.php" class="logo">LUMIO</a>
      <nav class="nav-main" aria-label="Navigation principale">
        <a href="index.php" class="nav-link">Boutique</a>
      </nav>
      <div class="header-actions">
        <a href="panier.php" class="btn-icon cart-btn" aria-label="Panier">
          <span class="cart-count" id="cart-count">0</span>
        </a>
      </div>
    </div>
  </header>

  <main class="auth-main">
    <div class="auth-card">
      <div class="auth-tabs" role="tablist">
        <button class="auth-tab <?= $activeTab === 'login' ? 'active' : '' ?>" id="tab-login" type="button">Connexion</button>
        <button class="auth-tab <?= $activeTab === 'register' ? 'active' : '' ?>" id="tab-register" type="button">Inscription</button>
      </div>

      <section class="auth-panel" id="panel-login" <?= $activeTab === 'register' ? 'hidden' : '' ?>>
        <h1 class="auth-title">Bon retour</h1>
        <p class="auth-sub">Connectez-vous pour retrouver votre espace.</p>
        <?php if ($errors['login'] !== ''): ?><p class="form-error-msg"><?= e($errors['login']) ?></p><?php endif; ?>
        <form class="auth-form" method="POST" action="login.php">
          <input type="hidden" name="action" value="login" />
          <div class="form-group">
            <label class="form-label" for="login-email">Adresse e-mail</label>
            <input class="form-input" type="email" id="login-email" name="email" required />
          </div>
          <div class="form-group">
            <label class="form-label" for="login-password">Mot de passe</label>
            <input class="form-input" type="password" id="login-password" name="password" required />
          </div>
          <button class="btn btn-primary btn-full" type="submit">Se connecter</button>
        </form>
      </section>

      <section class="auth-panel" id="panel-register" <?= $activeTab === 'login' ? 'hidden' : '' ?>>
        <h1 class="auth-title">Créer un compte</h1>
        <p class="auth-sub">Inscrivez-vous pour commander plus vite.</p>
        <?php if ($errors['register'] !== ''): ?><p class="form-error-msg"><?= e($errors['register']) ?></p><?php endif; ?>
        <form class="auth-form" method="POST" action="login.php">
          <input type="hidden" name="action" value="register" />
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="reg-first-name">Prénom</label>
              <input class="form-input" type="text" id="reg-first-name" name="first_name" required />
            </div>
            <div class="form-group">
              <label class="form-label" for="reg-last-name">Nom</label>
              <input class="form-input" type="text" id="reg-last-name" name="last_name" required />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="reg-email">Adresse e-mail</label>
            <input class="form-input" type="email" id="reg-email" name="email" required />
          </div>
          <div class="form-group">
            <label class="form-label" for="reg-password">Mot de passe</label>
            <input class="form-input" type="password" id="reg-password" name="password" minlength="8" required />
          </div>
          <button class="btn btn-primary btn-full" type="submit">Créer mon compte</button>
        </form>
      </section>
    </div>
  </main>

  <script>
    const loginTab = document.getElementById('tab-login');
    const registerTab = document.getElementById('tab-register');
    const loginPanel = document.getElementById('panel-login');
    const registerPanel = document.getElementById('panel-register');
    loginTab?.addEventListener('click', () => {
      loginTab.classList.add('active');
      registerTab.classList.remove('active');
      loginPanel.hidden = false;
      registerPanel.hidden = true;
    });
    registerTab?.addEventListener('click', () => {
      registerTab.classList.add('active');
      loginTab.classList.remove('active');
      registerPanel.hidden = false;
      loginPanel.hidden = true;
    });
  </script>
</body>
</html>
