<?php
/**
 * Résultats page - best offers display
 */
$pageTitle = 'Résultats de Votre Recherche';
require_once __DIR__ . '/../includes/header.php';

// Import classes
require_once __DIR__ . '/../classes/Voyage.php';
require_once __DIR__ . '/../classes/Itineraire.php';
require_once __DIR__ . '/../classes/Hebergement.php';
require_once __DIR__ . '/../classes/Transport.php';

// Get voyage ID from URL or session
$voyageId = $_GET['voyage_id'] ?? $_SESSION['last_voyage_id'] ?? null;

if (!$voyageId) {
    header('Location: planifier.php');
    exit();
}

$_SESSION['last_voyage_id'] = $voyageId;

$voyage = new Voyage();
$voyageData = $voyage->getById($voyageId);

if (!$voyageData) {
    header('Location: planifier.php');
    exit();
}

// Simulate search results (in real app, this would call external APIs)
$hebergements = [
    [
        'id' => 1,
        'name' => 'Grand Resort & Spa',
        'type' => 'Hôtel 5 étoiles',
        'location' => $voyageData['destination'],
        'price_per_night' => 450,
        'rating' => 5,
        'image' => 'images/hotel1.jpg',
        'amenities' => ['Spa', 'Piscine', 'Restaurant gastronomique', 'Plage privée']
    ],
    [
        'id' => 2,
        'name' => 'Villa Luxe Ocean View',
        'type' => 'Villa privée',
        'location' => $voyageData['destination'],
        'price_per_night' => 800,
        'rating' => 5,
        'image' => 'images/villa1.jpg',
        'amenities' => ['Piscine privée', 'Chef personnel', 'Vue océan', 'Jardin tropical']
    ],
    [
        'id' => 3,
        'name' => 'Boutique Hotel Charm',
        'type' 'Hôtel boutique',
        'location' => $voyageData['destination'],
        'price_per_night' => 350,
        'rating' => 4.5,
        'image' => 'images/hotel2.jpg',
        'amenities' => ['Restaurant', 'Bar rooftop', 'Service en chambre', 'Fitness center']
    ]
];

$transports = [
    [
        'id' => 1,
        'type' => 'Vol Business Class',
        'company' => 'Emirates',
        'departure_location' => 'Paris',
        'arrival_location' => $voyageData['destination'],
        'price' => 2500,
        'class' => 'Business'
    ],
    [
        'id' => 2,
        'type' => 'Vol First Class',
        'company' => 'Air France',
        'departure_location' => 'Paris',
        'arrival_location' => $voyageData['destination'],
        'price' => 4500,
        'class' => 'First'
    ],
    [
        'id' => 3,
        'type' => 'Transfert Privé',
        'company' => 'Luxury Cars',
        'departure_location' => 'Aéroport',
        'arrival_location' => 'Hôtel',
        'price' => 150,
        'class' => 'VIP'
    ]
];

$itineraireSuggere = [
    [
        'day' => 1,
        'title' => 'Arrivée et Installation',
        'activities' => [
            'Accueil à l\'aéroport par votre chauffeur privé',
            'Installation dans votre hébergement de luxe',
            'Dîner de bienvenue au restaurant gastronomique'
        ]
    ],
    [
        'day' => 2,
        'title' => 'Découverte et Détente',
        'activities' => [
            'Petit-déjeuner servi en chambre',
            'Visite guidée exclusive des sites emblématiques',
            'Après-midi détente au spa premium',
            'Soirée libre'
        ]
    ],
    [
        'day' => 3,
        'title' => 'Expérience Exclusive',
        'activities' => [
            'Excursion privée en yacht',
            'Déjeuner sur une île privée',
            'Coucher de soleil avec champagne',
            'Dîner aux chandelles sur la plage'
        ]
    ]
];
?>

<section class="results" style="margin-top: 80px; padding: 80px 0;">
    <div class="container">
        <h1 class="section-title">Votre Voyage à <?php echo htmlspecialchars($voyageData['destination']); ?></h1>
        
        <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <strong>Dates:</strong><br>
                    <?php echo date('d/m/Y', strtotime($voyageData['start_date'])); ?> - <?php echo date('d/m/Y', strtotime($voyageData['end_date'])); ?>
                </div>
                <div>
                    <strong>Voyageurs:</strong><br>
                    <?php echo $voyageData['travelers']; ?> personne(s)
                </div>
                <div>
                    <strong>Budget:</strong><br>
                    <?php echo number_format($voyageData['budget'], 0, ',', ' '); ?> €
                </div>
                <div>
                    <strong>Préférences:</strong><br>
                    <?php echo implode(', ', array_map('ucfirst', json_decode($voyageData['preferences'] ?? '[]'))); ?>
                </div>
            </div>
        </div>
        
        <!-- Hébergements -->
        <h2 style="margin: 3rem 0 1.5rem; color: var(--primary-color);">Hébergements Recommandés</h2>
        <div class="card-grid">
            <?php foreach ($hebergements as $hebergement): ?>
            <div class="card">
                <img src="<?php echo $hebergement['image']; ?>" alt="<?php echo htmlspecialchars($hebergement['name']); ?>" onerror="this.src='https://via.placeholder.com/400x200?text=Hotel'">
                <div class="card-content">
                    <h3 class="card-title"><?php echo htmlspecialchars($hebergement['name']); ?></h3>
                    <p style="color: #666; font-size: 0.9rem;"><?php echo htmlspecialchars($hebergement['type']); ?></p>
                    <p style="margin: 0.5rem 0;">⭐ <?php echo $hebergement['rating']; ?>/5</p>
                    <ul style="font-size: 0.85rem; color: #666; margin: 1rem 0;">
                        <?php foreach ($hebergement['amenities'] as $amenity): ?>
                        <li>• <?php echo htmlspecialchars($amenity); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="card-price"><?php echo number_format($hebergement['price_per_night'], 0, ',', ' '); ?> € / nuit</div>
                    <button class="btn" style="width: 100%;">Sélectionner</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Transports -->
        <h2 style="margin: 3rem 0 1.5rem; color: var(--primary-color);">Options de Transport</h2>
        <div class="card-grid">
            <?php foreach ($transports as $transport): ?>
            <div class="card">
                <div class="card-content">
                    <h3 class="card-title"><?php echo htmlspecialchars($transport['type']); ?></h3>
                    <p style="color: #666;"><strong><?php echo htmlspecialchars($transport['company']); ?></strong></p>
                    <p style="margin: 0.5rem 0;"><?php echo htmlspecialchars($transport['departure_location']); ?> → <?php echo htmlspecialchars($transport['arrival_location']); ?></p>
                    <p style="font-size: 0.9rem;">Classe: <span style="color: var(--secondary-color);"><?php echo htmlspecialchars($transport['class']); ?></span></p>
                    <div class="card-price"><?php echo number_format($transport['price'], 0, ',', ' '); ?> €</div>
                    <button class="btn" style="width: 100%;">Sélectionner</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Itinéraire Suggéré -->
        <h2 style="margin: 3rem 0 1.5rem; color: var(--primary-color);">Itinéraire Suggéré</h2>
        <div style="margin-top: 2rem;">
            <?php foreach ($itineraireSuggere as $jour): ?>
            <div style="background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; border-left: 4px solid var(--secondary-color);">
                <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">Jour <?php echo $jour['day']; ?>: <?php echo htmlspecialchars($jour['title']); ?></h3>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($jour['activities'] as $activity): ?>
                    <li style="padding: 0.3rem 0; border-bottom: 1px solid #eee;">• <?php echo htmlspecialchars($activity); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Action Buttons -->
        <div style="text-align: center; margin-top: 3rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="itineraire.php?voyage_id=<?php echo $voyageId; ?>" class="btn">Voir l'Itinéraire Complet</a>
            <a href="hebergements.php?voyage_id=<?php echo $voyageId; ?>" class="btn" style="background-color: var(--primary-color);">Tous les Hébergements</a>
            <a href="transports.php?voyage_id=<?php echo $voyageId; ?>" class="btn" style="background-color: var(--primary-color);">Tous les Transports</a>
            <button class="btn" style="background-color: #4CAF50;" onclick="alert('Fonctionnalité de réservation à venir')">Réserver ce Voyage</button>
        </div>
        
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
