<?php
/**
 * Homepage - index.php
 */
$pageTitle = 'Accueil';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Vivez l'Exceptionnel</h1>
        <p>Créez votre voyage de luxe sur mesure avec nos experts en voyages d'exception. Des expériences uniques vous attendent dans les destinations les plus prestigieuses du monde.</p>
        <a href="pages/planifier.php" class="btn">Commencer mon voyage</a>
    </div>
</section>

<!-- Featured Destinations -->
<section class="destinations">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Destinations Privilégiées</h2>
            <p class="section-subtitle">Découvrez nos sélection exclusives de paradis terrestres</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <div class="card-image-wrapper">
                    <img src="images/maldives.jpg" alt="Maldives">
                    <span class="card-badge">Populaire</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Maldives</h3>
                    <p class="card-description">Des villas sur pilotis dans un paradis tropical aux eaux cristallines</p>
                    <div class="card-price">À partir de 5 000€</div>
                    <div class="card-footer">
                        <a href="pages/planifier.php?destination=maldives" class="btn btn-secondary">Découvrir</a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-image-wrapper">
                    <img src="images/santorin.jpg" alt="Santorin">
                    <span class="card-badge">Coup de cœur</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Santorin, Grèce</h3>
                    <p class="card-description">Des couchers de soleil inoubliables sur la mer Égée et des suites luxueuses</p>
                    <div class="card-price">À partir de 3 500€</div>
                    <div class="card-footer">
                        <a href="pages/planifier.php?destination=santorin" class="btn btn-secondary">Découvrir</a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-image-wrapper">
                    <img src="images/dubai.jpg" alt="Dubaï">
                    <span class="card-badge">Luxe moderne</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Dubaï, EAU</h3>
                    <p class="card-description">Luxe moderne et expériences exclusives au cœur du désert</p>
                    <div class="card-price">À partir de 4 000€</div>
                    <div class="card-footer">
                        <a href="pages/planifier.php?destination=dubai" class="btn btn-secondary">Découvrir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Nos Services Exclusifs</h2>
            <p class="section-subtitle">Une expérience sur mesure, conçue pour vous</p>
        </div>
        <div class="card-grid">
            <div class="service-card">
                <span class="service-icon">🏨</span>
                <h3 class="card-title">Hébergements de Luxe</h3>
                <p class="card-description">Hôtels 5 étoiles, villas privées et resorts exclusifs sélectionnés avec soin pour votre confort absolu</p>
            </div>
            
            <div class="service-card">
                <span class="service-icon">✈️</span>
                <h3 class="card-title">Transports Premium</h3>
                <p class="card-description">Vols en classe affaires, chauffeurs privés et yachts de luxe pour voyager avec élégance</p>
            </div>
            
            <div class="service-card">
                <span class="service-icon">🎯</span>
                <h3 class="card-title">Expériences Sur Mesure</h3>
                <p class="card-description">Activités exclusives et itinéraires personnalisés selon vos envies les plus précieuses</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Ce Que Disent Nos Clients</h2>
            <p class="section-subtitle">Leurs retours d'expérience témoignent de notre engagement</p>
        </div>
        <div class="card-grid">
            <div class="testimonial-card">
                <p class="testimonial-text">"Un voyage absolument parfait du début à la fin. L'équipe a su anticiper tous nos désirs et créer des moments magiques."</p>
                <p class="testimonial-author">Sophie & Marc D.</p>
                <p class="testimonial-rating">⭐⭐⭐⭐⭐</p>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"Notre lune de miel aux Maldives était magique. Merci pour cette expérience inoubliable qui restera gravée dans nos mémoires !"</p>
                <p class="testimonial-author">Julie & Thomas L.</p>
                <p class="testimonial-rating">⭐⭐⭐⭐⭐</p>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"Service impeccable et attention aux détails. Je recommande vivement Luxe Voyage pour tous vos projets d'exception."</p>
                <p class="testimonial-author">Philippe M.</p>
                <p class="testimonial-rating">⭐⭐⭐⭐⭐</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <h2>Prêt à Vivre l'Exceptionnel ?</h2>
        <p>Contactez-nous dès aujourd'hui pour commencer à planifier votre voyage de rêve. Notre équipe d'experts est là pour réaliser vos envies les plus folles.</p>
        <a href="pages/planifier.php" class="btn">Planifier Mon Voyage</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
