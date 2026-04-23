<?php
/**
 * Itineraire page - day by day trip plan
 */
$pageTitle = 'Mon Itinéraire';
require_once __DIR__ . '/../includes/header.php';

// Import classes
require_once __DIR__ . '/../classes/Voyage.php';
require_once __DIR__ . '/../classes/Itineraire.php';

// Get voyage ID from URL
$voyageId = $_GET['voyage_id'] ?? $_SESSION['last_voyage_id'] ?? null;

if (!$voyageId) {
    header('Location: planifier.php');
    exit();
}

$voyage = new Voyage();
$voyageData = $voyage->getById($voyageId);

if (!$voyageData) {
    header('Location: planifier.php');
    exit();
}

$itineraire = new Itineraire();
$itineraireItems = $itineraire->getByVoyage($voyageId);

// Group items by day
$itineraireByDay = [];
foreach ($itineraireItems as $item) {
    $itineraireByDay[$item['day_number']][] = $item;
}

// Calculate number of days
$startDate = new DateTime($voyageData['start_date']);
$endDate = new DateTime($voyageData['end_date']);
$totalDays = $startDate->diff($endDate)->days + 1;

// If no itinerary in database, show suggested one
if (empty($itineraireItems)) {
    // Generate sample itinerary
    for ($day = 1; $day <= min($totalDays, 7); $day++) {
        $itineraireByDay[$day] = [
            [
                'activity_type' => 'general',
                'title' => "Jour $day - Activités",
                'description' => "Programme détaillé à personnaliser selon vos envies",
                'location' => $voyageData['destination'],
                'start_time' => '09:00',
                'end_time' => '18:00',
                'cost' => 0,
                'notes' => ''
            ]
        ];
    }
}
?>

<section class="itineraire-detail" style="margin-top: 80px; padding: 80px 0;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <h1 class="section-title" style="margin-bottom: 0;">Itinéraire - <?php echo htmlspecialchars($voyageData['destination']); ?></h1>
            <a href="resultats.php?voyage_id=<?php echo $voyageId; ?>" class="btn" style="background-color: var(--primary-color);">← Retour aux Résultats</a>
        </div>
        
        <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; margin-bottom: 3rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                <div>
                    <strong>Dates:</strong><br>
                    <?php echo date('d/m/Y', strtotime($voyageData['start_date'])); ?> - <?php echo date('d/m/Y', strtotime($voyageData['end_date'])); ?>
                </div>
                <div>
                    <strong>Durée:</strong><br>
                    <?php echo $totalDays; ?> jour(s)
                </div>
                <div>
                    <strong>Voyageurs:</strong><br>
                    <?php echo $voyageData['travelers']; ?> personne(s)
                </div>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="timeline" style="position: relative; padding-left: 2rem;">
            <?php 
            $dayCounter = 1;
            foreach ($itineraireByDay as $day => $activities): 
            ?>
            <div style="position: relative; margin-bottom: 3rem; padding-left: 2rem; border-left: 3px solid var(--secondary-color);">
                <div style="position: absolute; left: -2.6rem; top: 0; width: 2.5rem; height: 2.5rem; background: var(--secondary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    <?php echo $day; ?>
                </div>
                
                <h2 style="color: var(--primary-color); margin-bottom: 1.5rem;">Jour <?php echo $day; ?></h2>
                
                <?php foreach ($activities as $activity): ?>
                <div style="background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
                        <div style="flex: 1;">
                            <span style="background: var(--secondary-color); color: white; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase;">
                                <?php echo htmlspecialchars($activity['activity_type'] ?? 'Activité'); ?>
                            </span>
                            <h3 style="margin: 0.5rem 0;"><?php echo htmlspecialchars($activity['title']); ?></h3>
                            
                            <?php if (!empty($activity['location'])): ?>
                            <p style="color: #666; font-size: 0.9rem; margin: 0.5rem 0;">
                                📍 <?php echo htmlspecialchars($activity['location']); ?>
                            </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($activity['description'])): ?>
                            <p style="color: #666; margin: 0.5rem 0;"><?php echo htmlspecialchars($activity['description']); ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($activity['start_time']) || !empty($activity['end_time'])): ?>
                            <p style="font-size: 0.85rem; color: #888; margin-top: 0.5rem;">
                                🕐 <?php echo htmlspecialchars($activity['start_time'] ?? '--:--'); ?> - <?php echo htmlspecialchars($activity['end_time'] ?? '--:--'); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($activity['cost']) && $activity['cost'] > 0): ?>
                        <div style="text-align: right;">
                            <div style="font-size: 1.2rem; font-weight: bold; color: var(--secondary-color);">
                                <?php echo number_format($activity['cost'], 2, ',', ' '); ?> €
                            </div>
                            <div style="font-size: 0.75rem; color: #888;">par personne</div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($activity['notes'])): ?>
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee; font-size: 0.85rem; color: #666;">
                        💡 <?php echo htmlspecialchars($activity['notes']); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                
            </div>
            <?php 
            $dayCounter++;
            endforeach; 
            
            // Show remaining days if any
            for ($day = count($itineraireByDay) + 1; $day <= $totalDays; $day++): 
            ?>
            <div style="position: relative; margin-bottom: 3rem; padding-left: 2rem; border-left: 3px solid #ddd;">
                <div style="position: absolute; left: -2.6rem; top: 0; width: 2.5rem; height: 2.5rem; background: #ddd; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    <?php echo $day; ?>
                </div>
                
                <h2 style="color: #888; margin-bottom: 1.5rem;">Jour <?php echo $day; ?> - À personnaliser</h2>
                <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; border: 2px dashed #ddd; text-align: center; color: #888;">
                    <p>Cette journée n'a pas encore été planifiée.</p>
                    <button class="btn" style="margin-top: 1rem; background-color: #ddd; color: #666;" onclick="alert('Fonctionnalité d'édition à venir')">+ Ajouter des activités</button>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        
        <!-- Summary and Actions -->
        <div style="background: var(--primary-color); color: white; padding: 2rem; border-radius: 8px; margin-top: 3rem;">
            <h3 style="color: var(--secondary-color); margin-bottom: 1rem;">Résumé de Votre Séjour</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.85rem; opacity: 0.8;">Destination</div>
                    <div style="font-size: 1.2rem; font-weight: bold;"><?php echo htmlspecialchars($voyageData['destination']); ?></div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; opacity: 0.8;">Durée</div>
                    <div style="font-size: 1.2rem; font-weight: bold;"><?php echo $totalDays; ?> jours</div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; opacity: 0.8;">Voyageurs</div>
                    <div style="font-size: 1.2rem; font-weight: bold;"><?php echo $voyageData['travelers']; ?></div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; opacity: 0.8;">Budget estimé</div>
                    <div style="font-size: 1.2rem; font-weight: bold; color: var(--secondary-color);"><?php echo number_format($voyageData['budget'], 0, ',', ' '); ?> €</div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button class="btn" style="background-color: var(--secondary-color);" onclick="alert('Fonctionnalité d'export PDF à venir')">📥 Exporter en PDF</button>
                <button class="btn" style="background-color: transparent; border: 2px solid white;" onclick="alert('Fonctionnalité de partage à venir')">📤 Partager</button>
                <a href="planifier.php" class="btn" style="background-color: transparent; border: 2px solid white;">✏️ Modifier</a>
            </div>
        </div>
        
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
