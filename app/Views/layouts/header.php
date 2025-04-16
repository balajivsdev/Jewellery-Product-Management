<?php
$uri = service('uri');
$segment = $uri->getSegment(1);

if ($segment == 'register') {
    $pageTitle = 'Register | Jewellery management';
} elseif ($segment == 'login') {
    $pageTitle = 'Login | Jewellery management';
} elseif ($segment == 'product') {
    $pageTitle = 'Product | Jewellery management';
} else {
    $pageTitle = 'Jewellery management ';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=base_url('assets/css/jquery.toast.css')?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
    <link rel="icon" href="<?=base_url('images').'/jewellery-logo.jpg';?>">

</head>
<body class="bg-light">
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url('product') ?>">
        <img src="<?=base_url('images').'/jewellery-logo.jpg';?>" alt="logo" style="width:50px;height:50px;margin-right:10px">Jewellery Product Management</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <!-- Left Side Nav Links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <!-- <a class="nav-link" href="/dashboard">Dashboard</a> -->
        </li>
       
      </ul>

      <!-- Right Side: Session Name & Logout -->
      <ul class="navbar-nav ms-auto align-items-center">
    <?php if (session()->get('logged_in')): ?>
        <li class="nav-item">
            <a class="nav-link btn-primary" href="<?= base_url('product/create') ?>">Create Product</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-primary" href="<?= base_url('product') ?>">All Products</a>
        </li>
        <li class="nav-item me-2">
            <span class="nav-link"><?= esc(session()->get('user_name')) ?></span>
        </li>
        <li class="nav-item">
            <form action="<?= site_url('logout') ?>" method="post" class="d-inline">
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link btn-primary" href="<?= base_url('register') ?>">Register</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-primary" href="<?= base_url('login') ?>">Login</a>
        </li>
    <?php endif; ?>
</ul>
    </div>
  </div>
</nav>