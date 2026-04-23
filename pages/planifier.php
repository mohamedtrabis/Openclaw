<?php
/**
 * Planifier page - main planning form
 */
$pageTitle = 'Planifier Mon Voyage';
require_once __DIR__ . '/../includes/header.php';

// Import classes
require_once __DIR__ . '/../classes/Voyage.php';
require_once __DIR__ . '/../classes/Itineraire.php';
require_once __DIR__ . '/../classes/Hebergement.php';
require_once __DIR__ . '/../classes/Transport.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voyage = new Voyage();
    
    $data = [
        'destination' => sanitizeInput($_POST['destination'] ?? ''),
        'start_date' => $_POST['start_date'] ?? '',
        'end_date' => $_POST['end_date'] ?? '',
        'budget' => $_POST['budget'] ?? 0,
        'travelers' => $_POST['travelers'] ?? 1,
        'preferences' => $_POST['preferences'] ?? []
    ];
    
    $voyageId = $voyage->create($data);
    
    if ($voyageId) {
        header('Location: resultats.php?voyage_id=' . $voyageId);
        exit();
    } else {
        $error = "Une erreur est survenue lors de la création de votre voyage.";
    }
}
?>

<section class="planning-form" style="margin-top: 80px; padding: 80px 0;">
    <div class="container">
        <h1 class="section-title">Planifiez Votre Voyage de Luxe</h1>
        <p style="text-align: center; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Remplissez ce formulaire pour commencer à créer votre voyage sur mesure. Nos experts vous proposeront les meilleures options.
        </p>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error" style="background-color: #ffebee; color: #c62828; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form id="plan-form" method="POST" action="" style="max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            
            <div class="form-group">
                <label for="destination">Destination Souhaitée *</label>
                <input type="text" id="destination" name="destination" class="form-control" placeholder="Ex: Maldives, Santorin, Dubaï..." required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="start-date">Date de Départ *</label>
                    <input type="date" id="start-date" name="start_date" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="end-date">Date de Retour *</label>
                    <input type="date" id="end-date" name="end_date" class="form-control" required>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="budget">Budget Estimé (€) *</label>
                    <input type="number" id="budget" name="budget" class="form-control" placeholder="Ex: 5000" min="1000" step="100" required>
                </div>
                
                <div class="form-group">
                    <label for="travelers">Nombre de Voyageurs *</label>
                    <input type="number" id="travelers" name="travelers" class="form-control" placeholder="Ex: 2" min="1" max="20" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Préférences et Centres d'Intérêt</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                        <input type="checkbox" name="preferences[]" value="plage"> Plage & Détente
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                        <input type="checkbox" name="preferences[]" value="culture"> Culture & Histoire
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                        <input type="checkbox" name="preferences[]" value="aventure"> Aventure & Nature
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                        <input type="checkbox" name="preferences[]" value="gastronomie"> Gastronomie
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                        <input type="checkbox" name="preferences[]" value="luxe"> Expériences de Luxe
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                        <input type="checkbox" name="preferences[]" value="bien-etre"> Bien-être & Spa
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="notes">Commentaires Spéciaux</label>
                <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Décrivez vos attentes particulières, occasions spéciales, contraintes alimentaires..."></textarea>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <button type="submit" class="btn" style="padding: 15px 50px; font-size: 1.1rem;">Rechercher les Meilleures Offres</button>
            </div>
            
        </form>
    </div>
</section>

<script>
// Set minimum date to today
const today = new Date().toISOString().split('T')[0];
document.getElementById('start-date').setAttribute('min', today);
document.getElementById('end-date').setAttribute('min', today);

// Update end date min when start date changes
document.getElementById('start-date').addEventListener('change', function() {
    document.getElementById('end-date').setAttribute('min', this.value);
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
