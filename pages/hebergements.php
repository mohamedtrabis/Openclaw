<?php
/**
 * Hebergements page
 */
$pageTitle = 'Nos Hébergements de Luxe';
require_once __DIR__ . '/../includes/header.php';

// Import classes
require_once __DIR__ . '/../classes/Hebergement.php';

// Get voyage ID from URL if available
$voyageId = $_GET['voyage_id'] ?? null;

$hebergementClass = new Hebergement();

// Sample accommodations data (in real app, this would come from database or API)
$hebergements = [
    [
        'id' => 1,
        'name' => 'Grand Resort & Spa Maldives',
        'type' => 'Hôtel 5 étoiles',
        'location' => 'Maldives',
        'price_per_night' => 450,
        'rating' => 5,
        'image' => 'images/hotel-maldives.jpg',
        'amenities' => ['Spa', 'Piscine infinity', 'Restaurant gastronomique', 'Plage privée', 'Centre de plongée'],
        'description' => 'Un resort exclusif avec villas sur pilotis au cœur des eaux turquoise des Maldives.'
    ],
    [
        'id' => 2,
        'name' => 'Santorini Luxury Suites',
        'type' => 'Suite de luxe',
        'location' => 'Santorin, Grèce',
        'price_per_night' => 380,
        'rating' => 5,
        'image' => 'images/hotel-santorin.jpg',
        'amenities' => ['Vue sur le volcan', 'Jacuzzi privé', 'Petit-déjeuner inclus', 'Service de conciergerie'],
        'description' => "Des suites d'exception avec vue imprenable sur le coucher de soleil de Santorin."
    ],
    [
        'id' => 3,
        'name' => 'Burj Al Arab Dubai',
        'type' 'Hôtel palace',
        'location' => 'Dubaï, EAU',
        'price_per_night' => 1200,
        'rating' => 5,
        'image' => 'images/hotel-dubai.jpg',
        'amenities' => ['Butler 24/7', 'Accès plage privée', '9 restaurants étoilés', 'Spa Talise', 'Héliport'],
        'description' => "L'hôtel le plus luxueux du monde, une icône de Dubaï offrant un service inégalé."
    ],
    [
        'id' => 4,
        'name' => 'Villa Bali Oceanfront',
        'type' => 'Villa privée',
        'location' => 'Bali, Indonésie',
        'price_per_night' => 650,
        'rating' => 5,
        'image' => 'images/villa-bali.jpg',
        'amenities' => ['Piscine privée', 'Chef personnel', 'Jardin tropical', 'Accès direct plage', 'Spa in-villa'],
        'description' => 'Une villa balinaise traditionnelle avec tout le confort moderne face à l\'océan.'
    ],
    [
        'id' => 5,
        'name' => 'Paris Ritz Hotel',
        'type' => 'Hôtel historique',
        'location' => 'Paris, France',
        'price_per_night' => 950,
        'rating' => 5,
        'image' => 'images/hotel-paris.jpg',
        'amenities' => ['Bar Hemingway', 'Spa Chanel', 'Restaurant étoilé Michelin', 'Jardin secret'],
        'description' => 'Un palace parisien légendaire où le luxe et l\'histoire se rencontrent.'
    ],
    [
        'id' => 6,
        'name' => 'Swiss Alps Chalet',
        'type' => 'Chalet de luxe',
        'location' => 'Zermatt, Suisse',
        'price_per_night' => 1500,
        'rating' => 5,
        'image' => 'images/chalet-suisse.jpg',
        'amenities' => ['Vue Matterhorn', 'Spa & sauna', 'Chef privé', 'Ski-in/ski-out', 'Cave à vin'],
        'description' => 'Un chalet d\'exception au pied du Matterhorn pour des vacances ski de rêve.'
    ]
];

// Filter by location if specified
$searchLocation = $_GET['location'] ?? '';
if ($searchLocation) {
    $hebergements = array_filter($hebergements, function($h) use ($searchLocation) {
        return stripos($h['location'], $searchLocation) !== false || stripos($h['name'], $searchLocation) !== false;
    });
}

// Sort options
$sortBy = $_GET['sort'] ?? 'rating';
switch ($sortBy) {
    case 'price_asc':
        usort($hebergements, function($a, $b) { return $a['price_per_night'] - $b['price_per_night']; });
        break;
    case 'price_desc':
        usort($hebergements, function($a, $b) { return $b['price_per_night'] - $a['price_per_night']; });
        break;
    case 'rating':
    default:
        usort($hebergements, function($a, $b) { return $b['rating'] - $a['rating']; });
        break;
}
?>

<section class="hebergements-page" style="margin-top: 80px; padding: 80px 0;">
    <div class="container">
        <h1 class="section-title">Nos Hébergements de Luxe</h1>
        <p style="text-align: center; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; color: #666;">
            Découvrez notre sélection d'hébergements d'exception : hôtels 5 étoiles, villas privées, resorts exclusifs et palaces historiques.
        </p>
        
        <!-- Filters -->
        <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; margin-bottom: 3rem;">
            <form method="GET" action="" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: end;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="location" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Destination</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Ex: Maldives, Paris..." value="<?php echo htmlspecialchars($searchLocation); ?>">
                </div>
                
                <div style="min-width: 150px;">
                    <label for="sort" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Trier par</label>
                    <select id="sort" name="sort" class="form-control">
                        <option value="rating" <?php echo $sortBy === 'rating' ? 'selected' : ''; ?>>Meilleures notes</option>
                        <option value="price_asc" <?php echo $sortBy === 'price_asc' ? 'selected' : ''; ?>>Prix croissant</option>
                        <option value="price_desc" <?php echo $sortBy === 'price_desc' ? 'selected' : ''; ?>>Prix décroissant</option>
                    </select>
                </div>
                
                <button type="submit" class="btn">Filtrer</button>
                
                <?php if ($voyageId): ?>
                <input type="hidden" name="voyage_id" value="<?php echo htmlspecialchars($voyageId); ?>">
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Results count -->
        <p style="margin-bottom: 2rem; color: #666;">
            <strong><?php echo count($hebergements); ?></strong> hébergement(s) trouvé(s)
        </p>
        
        <!-- Accommodations grid -->
        <div class="card-grid">
            <?php foreach ($hebergements as $hebergement): ?>
            <div class="card">
                <img src="<?php echo $hebergement['image']; ?>" alt="<?php echo htmlspecialchars($hebergement['name']); ?>" onerror="this.src='https://via.placeholder.com/400x200?text=Hotel'">
                <div class="card-content">
                    <span style="background: var(--secondary-color); color: white; padding: 0.2rem 0.6rem; border-radius: 3px; font-size: 0.75rem; text-transform: uppercase;">
                        <?php echo htmlspecialchars($hebergement['type']); ?>
                    </span>
                    
                    <h3 class="card-title" style="margin-top: 0.5rem;"><?php echo htmlspecialchars($hebergement['name']); ?></h3>
                    
                    <p style="color: #666; font-size: 0.9rem; margin: 0.5rem 0;">
                        📍 <?php echo htmlspecialchars($hebergement['location']); ?>
                    </p>
                    
                    <p style="margin: 0.5rem 0; font-size: 0.9rem; color: #888;">
                        <?php echo htmlspecialchars(substr($hebergement['description'], 0, 100)); ?>...
                    </p>
                    
                    <p style="margin: 0.5rem 0;">⭐ <?php echo str_repeat('★', $hebergement['rating']); ?><span style="color: #ccc;"><?php echo str_repeat('☆', 5 - $hebergement['rating']); ?></span></p>
                    
                    <ul style="font-size: 0.8rem; color: #666; margin: 1rem 0; padding-left: 1rem;">
                        <?php foreach (array_slice($hebergement['amenities'], 0, 4) as $amenity): ?>
                        <li>• <?php echo htmlspecialchars($amenity); ?></li>
                        <?php endforeach; ?>
                        <?php if (count($hebergement['amenities']) > 4): ?>
                        <li style="color: var(--secondary-color);">+ <?php echo count($hebergement['amenities']) - 4; ?> autres</li>
                        <?php endif; ?>
                    </ul>
                    
                    <div class="card-price"><?php echo number_format($hebergement['price_per_night'], 0, ',', ' '); ?> € <span style="font-size: 0.8rem; font-weight: normal; color: #666;">/ nuit</span></div>
                    
                    <button class="btn" style="width: 100%; margin-top: 1rem;" onclick="alert('Fonctionnalité de réservation à venir')">
                        Voir les détails
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($hebergements)): ?>
        <div style="text-align: center; padding: 3rem; color: #666;">
            <p style="font-size: 1.2rem; margin-bottom: 1rem;">Aucun hébergement ne correspond à votre recherche.</p>
            <a href="hebergements.php" class="btn">Voir tous les hébergements</a>
        </div>
        <?php endif; ?>
        
        <!-- Back to results if coming from a voyage -->
        <?php if ($voyageId): ?>
        <div style="text-align: center; margin-top: 3rem;">
            <a href="resultats.php?voyage_id=<?php echo htmlspecialchars($voyageId); ?>" class="btn" style="background-color: var(--primary-color);">← Retour aux Résultats</a>
        </div>
        <?php endif; ?>
        
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
