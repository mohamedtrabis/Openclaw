<?php
/**
 * Transports page
 */
$pageTitle = 'Nos Options de Transport Premium';
require_once __DIR__ . '/../includes/header.php';

// Import classes
require_once __DIR__ . '/../classes/Transport.php';

// Get voyage ID from URL if available
$voyageId = $_GET['voyage_id'] ?? null;

$transportClass = new Transport();

// Sample transport data (in real app, this would come from database or API)
$transports = [
    [
        'id' => 1,
        'type' => 'Vol Business Class',
        'company' => 'Emirates',
        'route' => 'Paris → Dubaï',
        'departure_location' => 'Paris (CDG)',
        'arrival_location' => 'Dubaï (DXB)',
        'duration' => '6h 30min',
        'price' => 2500,
        'class' => 'Business',
        'image' => 'images/flight-business.jpg',
        'amenities' => ['Siège lit fully flat', 'Accès lounge', 'Cuisine gastronomique', 'Chauffeur privé']
    ],
    [
        'id' => 2,
        'type' => 'Vol First Class',
        'company' => 'Air France',
        'route' => 'Paris → New York',
        'departure_location' => 'Paris (CDG)',
        'arrival_location' => 'New York (JFK)',
        'duration' => '8h 15min',
        'price' => 4500,
        'class' => 'First',
        'image' => 'images/flight-first.jpg',
        'amenities' => ['Suite privée', 'Service à la carte', 'Champagne premium', 'Transfert limousine']
    ],
    [
        'id' => 3,
        'type' => 'Yacht Privé',
        'company' ->Luxury Yachts',
        'route' => 'Croisière Méditerranée',
        'departure_location' => 'Monaco',
        'arrival_location' => 'Saint-Tropez',
        'duration' => '7 jours',
        'price' => 15000,
        'class' => 'VIP',
        'image' => 'images/yacht.jpg',
        'amenities' => ['Équipage complet', 'Chef étoilé', 'Jetski & tenders', 'Héliport']
    ],
    [
        'id' => 4,
        'type' => 'Train de Luxe',
        'company' => 'Venice Simplon-Orient-Express',
        'route' => 'Paris → Venise',
        'departure_location' => 'Paris Gare de l\'Est',
        'arrival_location' => 'Venise Santa Lucia',
        'duration' => '2 jours',
        'price' => 3500,
        'class' => 'Grand Suite',
        'image' => 'images/orient-express.jpg',
        'amenities' => ['Cabine suite', 'Restaurant gastronomique', 'Bar piano', 'Service 24/7']
    ],
    [
        'id' => 5,
        'type' => 'Helicoptère Privé',
        'company' => 'Monacair',
        'route' => 'Nice → Monaco',
        'departure_location' => 'Nice Aéroport',
        'arrival_location' => 'Monaco Héliport',
        'duration' => '7 min',
        'price' => 450,
        'class' => 'Private',
        'image' => 'images/helicopter.jpg',
        'amenities' => ['Départ immédiat', 'Vue panoramique', 'Service VIP', 'Bagages inclus']
    ],
    [
        'id' => 6,
        'type' => 'Chauffeur Privé',
        'company' => 'Blacklane',
        'route' => 'Transfert ville',
        'departure_location' => 'Sur demande',
        'arrival_location' => 'Sur demande',
        'duration' => 'À la demande',
        'price' => 150,
        'class' => 'Business',
        'image' => 'images/chauffeur.jpg',
        'amenities' => ['Mercedes Classe S', 'Chauffeur professionnel', 'WiFi bord', 'Eau & presse']
    ]
];

// Filter by type if specified
$filterType = $_GET['type'] ?? '';
if ($filterType) {
    $transports = array_filter($transports, function($t) use ($filterType) {
        return stripos($t['type'], $filterType) !== false || stripos($t['company'], $filterType) !== false;
    });
}

// Sort options
$sortBy = $_GET['sort'] ?? 'price_asc';
switch ($sortBy) {
    case 'price_desc':
        usort($transports, function($a, $b) { return $b['price'] - $a['price']; });
        break;
    case 'type':
        usort($transports, function($a, $b) { return strcmp($a['type'], $b['type']); });
        break;
    case 'price_asc':
    default:
        usort($transports, function($a, $b) { return $a['price'] - $b['price']; });
        break;
}
?>

<section class="transports-page" style="margin-top: 80px; padding: 80px 0;">
    <div class="container">
        <h1 class="section-title">Nos Options de Transport Premium</h1>
        <p style="text-align: center; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; color: #666;">
            Voyagez avec élégance grâce à notre sélection de transports d'exception : vols en classe affaires, yachts privés, trains de luxe et chauffeurs VIP.
        </p>
        
        <!-- Filters -->
        <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; margin-bottom: 3rem;">
            <form method="GET" action="" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: end;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="type" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Type de transport</label>
                    <input type="text" id="type" name="type" class="form-control" placeholder="Ex: Vol, Yacht..." value="<?php echo htmlspecialchars($filterType); ?>">
                </div>
                
                <div style="min-width: 150px;">
                    <label for="sort" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Trier par</label>
                    <select id="sort" name="sort" class="form-control">
                        <option value="price_asc" <?php echo $sortBy === 'price_asc' ? 'selected' : ''; ?>>Prix croissant</option>
                        <option value="price_desc" <?php echo $sortBy === 'price_desc' ? 'selected' : ''; ?>>Prix décroissant</option>
                        <option value="type" <?php echo $sortBy === 'type' ? 'selected' : ''; ?>>Type</option>
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
            <strong><?php echo count($transports); ?></strong> option(s) de transport disponible(s)
        </p>
        
        <!-- Transport list -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($transports as $transport): ?>
            <div class="card" style="display: flex; flex-direction: row; overflow: hidden;">
                <img src="<?php echo $transport['image']; ?>" alt="<?php echo htmlspecialchars($transport['type']); ?>" style="width: 300px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/300x200?text=Transport'">
                <div class="card-content" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <span style="background: var(--secondary-color); color: white; padding: 0.2rem 0.6rem; border-radius: 3px; font-size: 0.75rem; text-transform: uppercase;">
                                    <?php echo htmlspecialchars($transport['class']); ?>
                                </span>
                                <h3 class="card-title" style="margin-top: 0.5rem;"><?php echo htmlspecialchars($transport['type']); ?></h3>
                                <p style="color: #666; font-size: 1rem;"><strong><?php echo htmlspecialchars($transport['company']); ?></strong></p>
                            </div>
                            
                            <div style="text-align: right;">
                                <div class="card-price" style="margin: 0;"><?php echo number_format($transport['price'], 0, ',', ' '); ?> €</div>
                                <div style="font-size: 0.75rem; color: #888;">à partir de</div>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin: 1rem 0; padding: 1rem 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
                            <div>
                                <div style="font-size: 0.75rem; color: #888;">Départ</div>
                                <div style="font-weight: 600;">🛫 <?php echo htmlspecialchars($transport['departure_location']); ?></div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: #888;">Arrivée</div>
                                <div style="font-weight: 600;">🛬 <?php echo htmlspecialchars($transport['arrival_location']); ?></div>
                            </div>
                            <div>
                                <div style="font-size: 0.75rem; color: #888;">Durée</div>
                                <div style="font-weight: 600;">⏱️ <?php echo htmlspecialchars($transport['duration']); ?></div>
                            </div>
                        </div>
                        
                        <ul style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.85rem; color: #666; list-style: none; padding: 0;">
                            <?php foreach ($transport['amenities'] as $amenity): ?>
                            <li style="background: #f5f5f5; padding: 0.3rem 0.8rem; border-radius: 20px;">✓ <?php echo htmlspecialchars($amenity); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <button class="btn" style="align-self: flex-start; margin-top: 1rem;" onclick="alert('Fonctionnalité de réservation à venir')">
                        Réserver ce transport
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($transports)): ?>
        <div style="text-align: center; padding: 3rem; color: #666;">
            <p style="font-size: 1.2rem; margin-bottom: 1rem;">Aucun transport ne correspond à votre recherche.</p>
            <a href="transports.php" class="btn">Voir tous les transports</a>
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

<style>
@media (max-width: 768px) {
    .card[style*="flex-direction: row"] {
        flex-direction: column !important;
    }
    .card[style*="flex-direction: row"] img {
        width: 100% !important;
        height: 200px;
    }
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
