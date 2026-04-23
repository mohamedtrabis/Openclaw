<?php
/**
 * Homepage - index.php
 */
$pageTitle = 'Accueil';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Vivez l'Exceptionnel</h1>
        <p>Créez votre voyage de luxe sur mesure avec nos experts en voyages d'exception</p>
        <a href="pages/planifier.php" class="btn">Commencer mon voyage</a>
    </div>
</section>

<!-- Featured Destinations -->
<section class="destinations">
    <div class="container">
        <h2 class="section-title">Destinations Privilégiées</h2>
        <div class="card-grid">
            <div class="card">
                <img src="images/maldives.jpg" alt="Maldives">
                <div class="card-content">
                    <h3 class="card-title">Maldives</h3>
                    <p>Des villas sur pilotis dans un paradis tropical</p>
                    <div class="card-price">À partir de 5 000€</div>
                    <a href="pages/planifier.php?destination=maldives" class="btn">Découvrir</a>
                </div>
            </div>
            
            <div class="card">
                <img src="images/santorin.jpg" alt="Santorin">
                <div class="card-content">
                    <h3 class="card-title">Santorin, Grèce</h3>
                    <p>Des couchers de soleil inoubliables sur la mer Égée</p>
                    <div class="card-price">À partir de 3 500€</div>
                    <a href="pages/planifier.php?destination=santorin" class="btn">Découvrir</a>
                </div>
            </div>
            
            <div class="card">
                <img src="images/dubai.jpg" alt="Dubaï">
                <div class="card-content">
                    <h3 class="card-title">Dubaï, EAU</h3>
                    <p>Luxe moderne et expériences exclusives</p>
                    <div class="card-price">À partir de 4 000€</div>
                    <a href="pages/planifier.php?destination=dubai" class="btn">Découvrir</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services" style="background-color: #f5f5f5;">
    <div class="container">
        <h2 class="section-title">Nos Services Exclusifs</h2>
        <div class="card-grid">
            <div class="card" style="text-align: center;">
                <div class="card-content">
                    <h3 class="card-title">🏨 Hébergements de Luxe</h3>
                    <p>Hôtels 5 étoiles, villas privées et resorts exclusifs sélectionnés avec soin</p>
                </div>
            </div>
            
            <div class="card" style="text-align: center;">
                <div class="card-content">
                    <h3 class="card-title">✈️ Transports Premium</h3>
                    <p>Vols en classe affaires, chauffeurs privés et yachts de luxe</p>
                </div>
            </div>
            
            <div class="card" style="text-align: center;">
                <div class="card-content">
                    <h3 class="card-title">🎯 Expériences Sur Mesure</h3>
                    <p>Activités exclusives et itinéraires personnalisés selon vos envies</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <h2 class="section-title">Ce Que Disent Nos Clients</h2>
        <div class="card-grid">
            <div class="card">
                <div class="card-content">
                    <p>"Un voyage absolument parfait du début à la fin. L'équipe a su anticiper tous nos désirs."</p>
                    <p><strong>- Sophie & Marc D.</strong></p>
                    <p>⭐⭐⭐⭐⭐</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <p>"Notre lune de miel aux Maldives était magique. Merci pour cette expérience inoubliable !"</p>
                    <p><strong>- Julie & Thomas L.</strong></p>
                    <p>⭐⭐⭐⭐⭐</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <p>"Service impeccable et attention aux détails. Je recommande vivement Luxe Voyage."</p>
                    <p><strong>- Philippe M.</strong></p>
                    <p>⭐⭐⭐⭐⭐</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta" style="background-color: var(--primary-color); color: white; text-align: center;">
    <div class="container">
        <h2 style="color: var(--secondary-color); margin-bottom: 1rem;">Prêt à Vivre l'Exceptionnel ?</h2>
        <p style="margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Contactez-nous dès aujourd'hui pour commencer à planifier votre voyage de rêve
        </p>
        <a href="pages/planifier.php" class="btn">Planifier Mon Voyage</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
