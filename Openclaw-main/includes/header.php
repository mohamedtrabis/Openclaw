<?php
/**
 * Shared header include
 */
session_start();
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Luxe Voyage - Créez votre voyage de luxe sur mesure">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Luxe Voyage</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo APP_URL; ?>/images/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo APP_URL; ?>" class="logo">LUXE VOYAGE</a>
            
            <ul class="nav-links">
                <li><a href="<?php echo APP_URL; ?>">Accueil</a></li>
                <li><a href="<?php echo APP_URL; ?>/pages/planifier.php">Planifier</a></li>
                <li><a href="<?php echo APP_URL; ?>/pages/hebergements.php">Hébergements</a></li>
                <li><a href="<?php echo APP_URL; ?>/pages/transports.php">Transports</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?php echo APP_URL; ?>/pages/compte.php">Mon Compte</a></li>
                    <li><a href="<?php echo APP_URL; ?>/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="<?php echo APP_URL; ?>/pages/login.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
            
            <button class="mobile-menu-btn" style="display: none;">☰</button>
        </div>
    </nav>
    
    <main>
