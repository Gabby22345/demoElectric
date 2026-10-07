<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{min-height:100vh;background:linear-gradient(135deg,#102a56,#1e40af);}.login-card{max-width:460px;margin:8vh auto;background:#fff;border-radius:20px;box-shadow:0 18px 50px #071b3c66;padding:2.5rem}.brand{color:#1e40af;font-weight:800;letter-spacing:.2px}</style>
</head>
<body>
<main class="container">
    <div class="login-card">
        <div class="text-center mb-4"><div class="fs-1">⚡</div><h1 class="brand h3">Puihaha Electric</h1><p class="text-muted mb-0">Customer account management</p></div>
        <?php if ($error): ?><div class="alert alert-danger"><?= esc($error) ?></div><?php endif; ?>
        <?php if ($success = session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc($success) ?></div><?php endif; ?>
        <form method="post" action="<?= base_url('login') ?>">
            <?= csrf_field() ?>
            <div class="mb-3"><label class="form-label" for="email">Email or username</label><input class="form-control form-control-lg" type="text" id="email" name="email" value="<?= esc(old('email')) ?>" required autofocus></div>
            <div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control form-control-lg" type="password" id="password" name="password" required></div>
            <button class="btn btn-warning btn-lg w-100 fw-semibold" type="submit">Sign in to dashboard</button>
        </form>
        <p class="text-center mt-4 mb-0">New customer? <a href="<?= base_url('register') ?>">Create an account</a></p>
        <p class="text-center mt-2 mb-0"><a href="<?= base_url() ?>">Return to website</a></p>
    </div>
</main>
</body>
</html>
