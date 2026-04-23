<?php
/**
 * Itineraire PHP class
 */

class Itineraire {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Create a new itinerary day/activity
     */
    public function create($data) {
        $sql = "INSERT INTO itineraires (voyage_id, day_number, activity_type, title, description, location, start_time, end_time, cost, notes) 
                VALUES (:voyage_id, :day_number, :activity_type, :title, :description, :location, :start_time, :end_time, :cost, :notes)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':voyage_id' => $data['voyage_id'],
            ':day_number' => $data['day_number'],
            ':activity_type' => sanitizeInput($data['activity_type']),
            ':title' => sanitizeInput($data['title']),
            ':description' => sanitizeInput($data['description'] ?? ''),
            ':location' => sanitizeInput($data['location'] ?? ''),
            ':start_time' => $data['start_time'] ?? null,
            ':end_time' => $data['end_time'] ?? null,
            ':cost' => $data['cost'] ?? 0,
            ':notes' => sanitizeInput($data['notes'] ?? '')
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Get itinerary by voyage ID
     */
    public function getByVoyage($voyageId) {
        $sql = "SELECT * FROM itineraires WHERE voyage_id = :voyage_id ORDER BY day_number, start_time";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':voyage_id' => $voyageId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get itinerary by day
     */
    public function getByDay($voyageId, $dayNumber) {
        $sql = "SELECT * FROM itineraires WHERE voyage_id = :voyage_id AND day_number = :day_number ORDER BY start_time";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':voyage_id' => $voyageId,
            ':day_number' => $dayNumber
        ]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update itinerary item
     */
    public function update($id, $data) {
        $sql = "UPDATE itineraires SET 
                day_number = :day_number,
                activity_type = :activity_type,
                title = :title,
                description = :description,
                location = :location,
                start_time = :start_time,
                end_time = :end_time,
                cost = :cost,
                notes = :notes
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':day_number' => $data['day_number'],
            ':activity_type' => sanitizeInput($data['activity_type']),
            ':title' => sanitizeInput($data['title']),
            ':description' => sanitizeInput($data['description'] ?? ''),
            ':location' => sanitizeInput($data['location'] ?? ''),
            ':start_time' => $data['start_time'] ?? null,
            ':end_time' => $data['end_time'] ?? null,
            ':cost' => $data['cost'] ?? 0,
            ':notes' => sanitizeInput($data['notes'] ?? '')
        ]);
    }
    
    /**
     * Delete itinerary item
     */
    public function delete($id) {
        $sql = "DELETE FROM itineraires WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Get total cost for voyage itinerary
     */
    public function getTotalCost($voyageId) {
        $sql = "SELECT SUM(cost) as total FROM itineraires WHERE voyage_id = :voyage_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':voyage_id' => $voyageId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    /**
     * Generate suggested itinerary based on preferences
     */
    public function generateSuggested($voyageId, $preferences) {
        // This would integrate with AI or external APIs to generate suggestions
        // For now, returns empty array
        return [];
    }
}
