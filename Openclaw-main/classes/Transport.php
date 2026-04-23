<?php
/**
 * Transport PHP class
 */

class Transport {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Create a new transport option
     */
    public function create($data) {
        $sql = "INSERT INTO transports (voyage_id, type, company, departure_location, arrival_location, departure_time, arrival_time, price, class, booking_reference, notes) 
                VALUES (:voyage_id, :type, :company, :departure_location, :arrival_location, :departure_time, :arrival_time, :price, :class, :booking_reference, :notes)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':voyage_id' => $data['voyage_id'],
            ':type' => sanitizeInput($data['type']),
            ':company' => sanitizeInput($data['company']),
            ':departure_location' => sanitizeInput($data['departure_location']),
            ':arrival_location' => sanitizeInput($data['arrival_location']),
            ':departure_time' => $data['departure_time'],
            ':arrival_time' => $data['arrival_time'],
            ':price' => $data['price'],
            ':class' => sanitizeInput($data['class'] ?? 'Economy'),
            ':booking_reference' => sanitizeInput($data['booking_reference'] ?? ''),
            ':notes' => sanitizeInput($data['notes'] ?? '')
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Get transport by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM transports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Get all transports for a voyage
     */
    public function getByVoyage($voyageId) {
        $sql = "SELECT * FROM transports WHERE voyage_id = :voyage_id ORDER BY departure_time";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':voyage_id' => $voyageId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Search transports
     */
    public function search($criteria) {
        $sql = "SELECT * FROM transports WHERE 1=1";
        $params = [];
        
        if (!empty($criteria['type'])) {
            $sql .= " AND type = :type";
            $params[':type'] = sanitizeInput($criteria['type']);
        }
        
        if (!empty($criteria['departure_location'])) {
            $sql .= " AND departure_location LIKE :departure_location";
            $params[':departure_location'] = '%' . sanitizeInput($criteria['departure_location']) . '%';
        }
        
        if (!empty($criteria['arrival_location'])) {
            $sql .= " AND arrival_location LIKE :arrival_location";
            $params[':arrival_location'] = '%' . sanitizeInput($criteria['arrival_location']) . '%';
        }
        
        if (!empty($criteria['min_price'])) {
            $sql .= " AND price >= :min_price";
            $params[':min_price'] = $criteria['min_price'];
        }
        
        if (!empty($criteria['max_price'])) {
            $sql .= " AND price <= :max_price";
            $params[':max_price'] = $criteria['max_price'];
        }
        
        $sql .= " ORDER BY price ASC, departure_time ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Update transport
     */
    public function update($id, $data) {
        $sql = "UPDATE transports SET 
                type = :type,
                company = :company,
                departure_location = :departure_location,
                arrival_location = :arrival_location,
                departure_time = :departure_time,
                arrival_time = :arrival_time,
                price = :price,
                class = :class,
                booking_reference = :booking_reference,
                notes = :notes
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':type' => sanitizeInput($data['type']),
            ':company' => sanitizeInput($data['company']),
            ':departure_location' => sanitizeInput($data['departure_location']),
            ':arrival_location' => sanitizeInput($data['arrival_location']),
            ':departure_time' => $data['departure_time'],
            ':arrival_time' => $data['arrival_time'],
            ':price' => $data['price'],
            ':class' => sanitizeInput($data['class'] ?? 'Economy'),
            ':booking_reference' => sanitizeInput($data['booking_reference'] ?? ''),
            ':notes' => sanitizeInput($data['notes'] ?? '')
        ]);
    }
    
    /**
     * Delete transport
     */
    public function delete($id) {
        $sql = "DELETE FROM transports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Get transport options between two locations
     */
    public function getOptions($from, $to, $date) {
        $sql = "SELECT * FROM transports 
                WHERE departure_location LIKE :from 
                AND arrival_location LIKE :to
                AND DATE(departure_time) = :date
                ORDER BY price ASC, departure_time ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':from' => '%' . sanitizeInput($from) . '%',
            ':to' => '%' . sanitizeInput($to) . '%',
            ':date' => $date
        ]);
        
        return $stmt->fetchAll();
    }
}
