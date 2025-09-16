<?php

class Event {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all events with pagination
    public function getAllEvents($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        // Convertir a enteros y validar
        $page = (int)$page;
        $perPage = (int)$perPage;
        $offset = (int)$offset;
        
        if ($page <= 0) $page = 1;
        if ($perPage <= 0) $perPage = 10;
        if ($offset < 0) $offset = 0;
        
        error_log("Event::getAllEvents called with page: {$page}, perPage: {$perPage}, offset: {$offset}");
        
        // Usar LIMIT y OFFSET directos para evitar problemas con parámetros
        $this->db->query('SELECT e.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                         FROM eventos e 
                         LEFT JOIN users u ON e.usuario_id = u.id 
                         ORDER BY e.fecha DESC, e.hora DESC 
                         LIMIT ' . $perPage . ' OFFSET ' . $offset);
        
        error_log("Using direct LIMIT: {$perPage}, OFFSET: {$offset}");
        
        try {
            $result = $this->db->resultSet();
            error_log("getAllEvents result count: " . count($result));
            return $result;
        } catch (Exception $e) {
            error_log("Error in getAllEvents: " . $e->getMessage());
            return [];
        }
    }
    
    // Get a single event by ID
    public function getEventById($id) {
        $this->db->query('SELECT e.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                         FROM eventos e 
                         LEFT JOIN users u ON e.usuario_id = u.id 
                         WHERE e.id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Get recent events
    public function getRecentEvents($limit = 5) {
        error_log("Event::getRecentEvents called with limit: " . $limit);
        
        // Convertir a entero y validar
        $limit = (int)$limit;
        if ($limit <= 0) $limit = 5;
        
        // Usar LIMIT directo en lugar de parámetro para evitar problemas
        $this->db->query('SELECT * FROM eventos 
                         WHERE fecha >= CURDATE() 
                         ORDER BY fecha ASC, hora ASC 
                         LIMIT ' . $limit);
        
        error_log("Using direct LIMIT: " . $limit);
        
        try {
            $result = $this->db->resultSet();
            error_log("getRecentEvents result count: " . count($result));
            return $result;
        } catch (Exception $e) {
            error_log("Error in getRecentEvents: " . $e->getMessage());
            return [];
        }
    }
    
    // Create a new event
    public function createEvent($data) {
        $this->db->query('INSERT INTO eventos 
                         (titulo, descripcion, fecha, hora, lugar, imagen_url, es_publico, usuario_id, created_at) 
                         VALUES (:titulo, :descripcion, :fecha, :hora, :lugar, :imagen_url, :es_publico, :usuario_id, NOW())');
        
        // Bind values
        $this->db->bind(':titulo', $data['titulo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':fecha', $data['fecha']);
        $this->db->bind(':hora', $data['hora']);
        $this->db->bind(':lugar', $data['lugar']);
        $this->db->bind(':imagen_url', $data['imagen_url'] ?? null);
        $this->db->bind(':es_publico', $data['es_publico'] ?? 0);
        $this->db->bind(':usuario_id', $data['usuario_id']);
        
        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    // Update an event
    public function updateEvent($data) {
        $sql = 'UPDATE eventos SET 
                titulo = :titulo,
                descripcion = :descripcion,
                fecha = :fecha,
                hora = :hora,
                lugar = :lugar,
                es_publico = :es_publico';
        
        // Add image URL to update if provided
        if (!empty($data['imagen_url'])) {
            $sql .= ', imagen_url = :imagen_url';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':titulo', $data['titulo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':fecha', $data['fecha']);
        $this->db->bind(':hora', $data['hora']);
        $this->db->bind(':lugar', $data['lugar']);
        $this->db->bind(':es_publico', $data['es_publico'] ?? 0);
        
        // Bind image URL if provided
        if (!empty($data['imagen_url'])) {
            $this->db->bind(':imagen_url', $data['imagen_url']);
        }
        
        // Execute
        return $this->db->execute();
    }
    
    // Delete an event
    public function deleteEvent($id) {
        $this->db->query('DELETE FROM eventos WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Get total count of events
    public function getEventCount() {
        $this->db->query('SELECT COUNT(*) as count FROM eventos');
        $result = $this->db->single();
        return $result->count;
    }
    
    // Get events for a specific month and year (for calendar view)
    public function getEventsByMonth($month, $year) {
        // Convertir a enteros y validar
        $month = (int)$month;
        $year = (int)$year;
        
        if ($month < 1 || $month > 12) $month = date('n');
        if ($year < 1900) $year = date('Y');
        
        error_log("Event::getEventsByMonth called with month: {$month}, year: {$year}");
        
        $this->db->query('SELECT id, titulo, fecha, hora, es_publico 
                         FROM eventos 
                         WHERE MONTH(fecha) = :month AND YEAR(fecha) = :year 
                         ORDER BY fecha, hora');
        
        error_log("Binding month: {$month}, year: {$year}");
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        
        try {
            $result = $this->db->resultSet();
            error_log("getEventsByMonth result count: " . count($result));
            return $result;
        } catch (Exception $e) {
            error_log("Error in getEventsByMonth: " . $e->getMessage());
            return [];
        }
    }
    
    // Search events with filters
    public function searchEvents($filters = [], $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = [];
        
        // Construir la consulta base
        $sql = 'SELECT e.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                FROM eventos e 
                LEFT JOIN users u ON e.usuario_id = u.id';
        
        // Aplicar filtros
        if (!empty($filters['search'])) {
            $where[] = '(e.titulo LIKE :search OR e.descripcion LIKE :search OR e.lugar LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['fecha_desde'])) {
            $where[] = 'e.fecha >= :fecha_desde';
            $params[':fecha_desde'] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $where[] = 'e.fecha <= :fecha_hasta';
            $params[':fecha_hasta'] = $filters['fecha_hasta'];
        }
        
        if (isset($filters['es_publico']) && $filters['es_publico'] !== '') {
            $where[] = 'e.es_publico = :es_publico';
            $params[':es_publico'] = (int)$filters['es_publico'];
        }
        
        // Añadir condiciones WHERE si existen
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        
        // Ordenar y paginar
        $sql .= ' ORDER BY e.fecha DESC, e.hora DESC';
        $sql .= ' LIMIT :limit OFFSET :offset';
        
        // Preparar la consulta
        $this->db->query($sql);
        
        // Vincular parámetros
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        // Vincular parámetros de paginación
        $this->db->bind(':limit', $perPage, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        
        // Ejecutar y devolver resultados
        return $this->db->resultSet();
    }
    
    // Count total events matching search filters
    public function countSearchEvents($filters = []) {
        $params = [];
        $where = [];
        
        // Construir la consulta base
        $sql = 'SELECT COUNT(*) as total FROM eventos e';
        
        // Aplicar filtros (mismos que en searchEvents)
        if (!empty($filters['search'])) {
            $where[] = '(e.titulo LIKE :search OR e.descripcion LIKE :search OR e.lugar LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['fecha_desde'])) {
            $where[] = 'e.fecha >= :fecha_desde';
            $params[':fecha_desde'] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $where[] = 'e.fecha <= :fecha_hasta';
            $params[':fecha_hasta'] = $filters['fecha_hasta'];
        }
        
        if (isset($filters['es_publico']) && $filters['es_publico'] !== '') {
            $where[] = 'e.es_publico = :es_publico';
            $params[':es_publico'] = (int)$filters['es_publico'];
        }
        
        // Añadir condiciones WHERE si existen
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        
        // Preparar la consulta
        $this->db->query($sql);
        
        // Vincular parámetros
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        // Ejecutar y devolver el total
        $result = $this->db->single();
        return $result ? $result->total : 0;
    }
}
