<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>body{background:#f3f6fb}.navbar{background:#102a56}.brand{color:#fff;font-weight:800}.card{border:0;border-radius:18px;box-shadow:0 8px 30px #102a5612}</style>
</head>
<body>
<nav class="navbar navbar-dark"><div class="container"><a class="navbar-brand brand" href="<?= base_url('dashboard') ?>">⚡ Puihaha Electric</a><div class="d-flex align-items-center gap-3 text-white"><span><?= esc(session()->get('user_name')) ?></span><a class="btn btn-outline-light btn-sm" href="<?= base_url('logout') ?>">Log out</a></div></div></nav>
<main class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><div><p class="text-primary mb-1">Customer accounts</p><h1 class="h3 mb-0"><?= isset($account['id']) ? 'Edit account' : 'Create new account' ?></h1></div><a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Dashboard</a></div>
<?php if ($errors): ?><div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0"><?php foreach ($errors as $message): ?><li><?= esc($message) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<div class="card p-4"><form method="post" action="<?= base_url(isset($account['id']) ? 'accounts/update/'.$account['id'] : 'accounts') ?>"><?= csrf_field() ?><div class="row g-3">
    <div class="col-md-6"><label class="form-label">Account number</label><input class="form-control" name="account_number" value="<?= esc($account['account_number'] ?? '') ?>" required></div>
    <div class="col-md-6"><label class="form-label">Customer name</label><input class="form-control" name="customer_name" value="<?= esc($account['customer_name'] ?? '') ?>" required></div>
    <div class="col-12"><label class="form-label">Address</label><input class="form-control" name="address" value="<?= esc($account['address'] ?? '') ?>" required></div>
    <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= esc($account['phone'] ?? '') ?>" required></div>
    <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= esc($account['email'] ?? '') ?>" required></div>
    <div class="col-md-4"><label class="form-label">Meter number</label><input class="form-control" name="meter_number" value="<?= esc($account['meter_number'] ?? '') ?>" required></div>
    <div class="col-md-4"><label class="form-label">Connection type</label><select class="form-select" name="connection_type" required><?php foreach (['residential','commercial','industrial'] as $option): ?><option value="<?= $option ?>" <?= ($account['connection_type'] ?? '') === $option ? 'selected' : '' ?>><?= ucfirst($option) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status" required><?php foreach (['active','inactive','suspended'] as $option): ?><option value="<?= $option ?>" <?= ($account['status'] ?? 'active') === $option ? 'selected' : '' ?>><?= ucfirst($option) ?></option><?php endforeach; ?></select></div>
    <div class="col-12 d-flex justify-content-end gap-2 mt-4"><a href="<?= base_url('dashboard') ?>" class="btn btn-light">Cancel</a><button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Save account</button></div>
</div></form></div></main></body></html>
