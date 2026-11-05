<?php

$mensajeMantenimiento = $mensajeMantenimiento
    ?? 'NutriControl se encuentra temporalmente en mantenimiento.';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modo mantenimiento | NutriControl</title>
    <link rel="icon" href="<?= BASE_URL ?>public/img/logo.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/login.css">
    <style>
        .maintenance-screen{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;background:#f4f6f8;font-family:Poppins,Arial,sans-serif}
        .maintenance-box{max-width:620px;width:100%;padding:42px 34px;text-align:center;background:#fff;border-radius:22px;box-shadow:0 15px 45px rgba(0,0,0,.1)}
        .maintenance-box img{width:82px;height:82px;object-fit:contain;margin-bottom:18px}
        .maintenance-box .icon{width:70px;height:70px;margin:0 auto 20px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#fff0f0;color:#d64545;font-size:28px}
        .maintenance-box h1{margin:0 0 10px;font-size:28px;color:#222}
        .maintenance-box p{margin:0 auto 24px;max-width:500px;line-height:1.7;color:#666}
        .maintenance-box a{display:inline-flex;align-items:center;gap:8px;text-decoration:none;padding:11px 18px;border-radius:10px;background:#222;color:#fff}
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
</head>
<body>
    <div class="maintenance-screen">
        <div class="maintenance-box">
            <img src="<?= BASE_URL ?>public/img/logo.png" alt="NutriControl">
            <div class="icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
            <h1>Estamos en mantenimiento</h1>
            <p><?= nl2br(htmlspecialchars($mensajeMantenimiento)) ?></p>
            <a href="<?= BASE_URL ?>index.php?url=auth/logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar sesión
            </a>
        </div>
    </div>
</body>
</html>
