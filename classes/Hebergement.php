<?php
/**
 * Hebergement PHP class
 */

class Hebergement {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Create a new accommodation
     */
    public function create($data) {
        $sql = "INSERT INTO hebergements (voyage_id, name, type, location, check_in, check_out, price_per_night, nights, total_price, amenities, rating, notes) 
                VALUES (:voyage_id, :name, :type, :location, :check_in, :check_out, :price_per_night, :nights, :total_price, :amenities, :rating, :notes)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':voyage_id' => $data['voyage_id'],
            ':name' => sanitizeInput($data['name']),
            ':type' => sanitizeInput($data['type']),
            ':location' => sanitizeInput($data['location']),
            ':check_in' => $data['check_in'],
            ':check_out' => $data['check_out'],
            ':price_per_night' => $data['price_per_night'],
            ':nights' => $data['nights'],
            ':total_price' => $data['total_price'],
            ':amenities' => json_encode($data['amenities'] ?? []),
            ':rating' => $data['rating'] ?? 0,
            ':notes' => sanitizeInput($data['notes'] ?? '')
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Get accommodation by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM hebergements WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Get all accommodations for a voyage
     */
    public function getByVoyage($voyageId) {
        $sql = "SELECT * FROM hebergements WHERE voyage_id = :voyage_id ORDER BY check_in";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':voyage_id' => $voyageId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Search accommodations
     */
    public function search($criteria) {
        $sql = "SELECT * FROM hebergements WHERE 1=1";
        $params = [];
        
        if (!empty($criteria['location'])) {
            $sql .= " AND location LIKE :location";
            $params[':location'] = '%' . sanitizeInput($criteria['location']) . '%';
        }
        
        if (!empty($criteria['type'])) {
            $sql .= " AND type = :type";
            $params[':type'] = sanitizeInput($criteria['type']);
        }
        
        if (!empty($criteria['min_price'])) {
            $sql .= " AND price_per_night >= :min_price";
            $params[':min_price'] = $criteria['min_price'];
        }
        
        if (!empty($criteria['max_price'])) {
            $sql .= " AND price_per_night <= :max_price";
            $params[':max_price'] = $criteria['max_price'];
        }
        
        if (!empty($criteria['min_rating'])) {
            $sql .= " AND rating >= :min_rating";
            $params[':min_rating'] = $criteria['min_rating'];
        }
        
        $sql .= " ORDER BY rating DESC, price_per_night ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Update accommodation
     */
    public function update($id, $data) {
        $sql = "UPDATE hebergements SET 
                name = :name,
                type = :type,
                location = :location,
                check_in = :check_in,
                check_out = :check_out,
                price_per_night = :price_per_night,
                nights = :nights,
                total_price = :total_price,
                amenities = :amenities,
                rating = :rating,
                notes = :notes
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => sanitizeInput($data['name']),
            ':type' => sanitizeInput($data['type']),
            ':location' => sanitizeInput($data['location']),
            ':check_in' => $data['check_in'],
            ':check_out' => $data['check_out'],
            ':price_per_night' => $data['price_per_night'],
            ':nights' => $data['nights'],
            ':total_price' => $data['total_price'],
            ':amenities' => json_encode($data['amenities'] ?? []),
            ':rating' => $data['rating'] ?? 0,
            ':notes' => sanitizeInput($data['notes'] ?? '')
        ]);
    }
    
    /**
     * Delete accommodation
     */
    public function delete($id) {
        $sql = "DELETE FROM hebergements WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Get available accommodations by date range
     */
    public function getAvailable($location, $checkIn, $checkOut) {
        $sql = "SELECT * FROM hebergements 
                WHERE location LIKE :location 
                AND check_in <= :check_in 
                AND check_out >= :check_out
                ORDER BY rating DESC, price_per_night ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':location' => '%' . sanitizeInput($location) . '%',
            ':check_in' => $checkIn,
            ':check_out' => $checkOut
        ]);
        
        return $stmt->fetchAll();
    }
}
