<?php
/**
 * Voyage PHP class - Core business logic
 */

class Voyage {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Create a new voyage
     */
    public function create($data) {
        $sql = "INSERT INTO voyages (user_id, destination, start_date, end_date, budget, travelers, preferences, status) 
                VALUES (:user_id, :destination, :start_date, :end_date, :budget, :travelers, :preferences, :status)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'] ?? null,
            ':destination' => sanitizeInput($data['destination']),
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':budget' => $data['budget'],
            ':travelers' => $data['travelers'],
            ':preferences' => json_encode($data['preferences'] ?? []),
            ':status' => 'pending'
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Get voyage by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM voyages WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Get all voyages for a user
     */
    public function getByUser($userId) {
        $sql = "SELECT * FROM voyages WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update voyage
     */
    public function update($id, $data) {
        $sql = "UPDATE voyages SET 
                destination = :destination,
                start_date = :start_date,
                end_date = :end_date,
                budget = :budget,
                travelers = :travelers,
                preferences = :preferences,
                status = :status
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':destination' => sanitizeInput($data['destination']),
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':budget' => $data['budget'],
            ':travelers' => $data['travelers'],
            ':preferences' => json_encode($data['preferences'] ?? []),
            ':status' => $data['status'] ?? 'pending'
        ]);
    }
    
    /**
     * Delete voyage
     */
    public function delete($id) {
        $sql = "DELETE FROM voyages WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Search voyages based on criteria
     */
    public function search($criteria) {
        $sql = "SELECT * FROM voyages WHERE 1=1";
        $params = [];
        
        if (!empty($criteria['destination'])) {
            $sql .= " AND destination LIKE :destination";
            $params[':destination'] = '%' . sanitizeInput($criteria['destination']) . '%';
        }
        
        if (!empty($criteria['min_budget'])) {
            $sql .= " AND budget >= :min_budget";
            $params[':min_budget'] = $criteria['min_budget'];
        }
        
        if (!empty($criteria['max_budget'])) {
            $sql .= " AND budget <= :max_budget";
            $params[':max_budget'] = $criteria['max_budget'];
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Calculate total cost of voyage
     */
    public function calculateTotalCost($voyageId) {
        $total = 0;
        
        // Get accommodation costs
        $itineraire = new Itineraire();
        $activities = $itineraire->getByVoyage($voyageId);
        
        foreach ($activities as $activity) {
            $total += $activity['cost'] ?? 0;
        }
        
        return $total;
    }
}
