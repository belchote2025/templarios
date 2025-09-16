<?php

class News {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all news with pagination
    public function getAllNews($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        // Convertir a enteros y validar
        $page = (int)$page;
        $perPage = (int)$perPage;
        $offset = (int)$offset;
        
        if ($page <= 0) $page = 1;
        if ($perPage <= 0) $perPage = 10;
        if ($offset < 0) $offset = 0;
        
        error_log("News::getAllNews called with page: {$page}, perPage: {$perPage}, offset: {$offset}");
        
        $this->db->query('SELECT n.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                         FROM noticias n 
                         LEFT JOIN users u ON n.autor_id = u.id 
                         ORDER BY n.fecha_publicacion DESC 
                         LIMIT ' . $perPage . ' OFFSET ' . $offset);
        
        try {
            $result = $this->db->resultSet();
            error_log("getAllNews result count: " . count($result));
            return $result;
        } catch (Exception $e) {
            error_log("Error in getAllNews: " . $e->getMessage());
            return [];
        }
    }
    
    // Get a single news by ID
    public function getNewsById($id) {
        $this->db->query('SELECT n.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                         FROM noticias n 
                         LEFT JOIN users u ON n.autor_id = u.id 
                         WHERE n.id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Get published news for public display
    public function getPublishedNews($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $page = (int)$page;
        $perPage = (int)$perPage;
        $offset = (int)$offset;
        
        if ($page <= 0) $page = 1;
        if ($perPage <= 0) $perPage = 10;
        if ($offset < 0) $offset = 0;
        
        $this->db->query('SELECT n.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                         FROM noticias n 
                         LEFT JOIN users u ON n.autor_id = u.id 
                         WHERE n.estado = "publicado"
                         ORDER BY n.fecha_publicacion DESC 
                         LIMIT ' . $perPage . ' OFFSET ' . $offset);
        
        try {
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            error_log("Error in getPublishedNews: " . $e->getMessage());
            return [];
        }
    }
    
    // Get recent news for dashboard
    public function getRecentNews($limit = 5) {
        $limit = (int)$limit;
        if ($limit <= 0) $limit = 5;
        
        $this->db->query('SELECT n.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                         FROM noticias n 
                         LEFT JOIN users u ON n.autor_id = u.id 
                         ORDER BY n.fecha_publicacion DESC 
                         LIMIT ' . $limit);
        
        try {
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            error_log("Error in getRecentNews: " . $e->getMessage());
            return [];
        }
    }
    
    // Create a new news
    public function createNews($data) {
        $this->db->query('INSERT INTO noticias 
                         (titulo, contenido, imagen_portada, autor_id, estado, fecha_publicacion) 
                         VALUES (:titulo, :contenido, :imagen_portada, :autor_id, :estado, :fecha_publicacion)');
        
        // Bind values
        $this->db->bind(':titulo', $data['titulo']);
        $this->db->bind(':contenido', $data['contenido']);
        $this->db->bind(':imagen_portada', $data['imagen_portada'] ?? null);
        $this->db->bind(':autor_id', $data['autor_id'] ?? null);
        $this->db->bind(':estado', $data['estado'] ?? 'borrador');
        $this->db->bind(':fecha_publicacion', $data['fecha_publicacion'] ?? date('Y-m-d H:i:s'));
        
        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    // Update a news
    public function updateNews($data) {
        $sql = 'UPDATE noticias SET 
                titulo = :titulo,
                contenido = :contenido,
                estado = :estado,
                fecha_actualizacion = NOW()';
        
        // Add image to update if provided
        if (!empty($data['imagen_portada'])) {
            $sql .= ', imagen_portada = :imagen_portada';
        }
        
        // Add publication date if provided
        if (!empty($data['fecha_publicacion'])) {
            $sql .= ', fecha_publicacion = :fecha_publicacion';
        }
        
        $sql .= ' WHERE id = :id';
        
        $this->db->query($sql);
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':titulo', $data['titulo']);
        $this->db->bind(':contenido', $data['contenido']);
        $this->db->bind(':estado', $data['estado']);
        
        // Bind optional values
        if (!empty($data['imagen_portada'])) {
            $this->db->bind(':imagen_portada', $data['imagen_portada']);
        }
        
        if (!empty($data['fecha_publicacion'])) {
            $this->db->bind(':fecha_publicacion', $data['fecha_publicacion']);
        }
        
        // Execute
        return $this->db->execute();
    }
    
    // Delete a news
    public function deleteNews($id) {
        $this->db->query('DELETE FROM noticias WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Get total count of news
    public function getNewsCount() {
        $this->db->query('SELECT COUNT(*) as count FROM noticias');
        $result = $this->db->single();
        return $result->count;
    }
    
    // Get count by status
    public function getNewsCountByStatus($status = null) {
        if ($status) {
            $this->db->query('SELECT COUNT(*) as count FROM noticias WHERE estado = :estado');
            $this->db->bind(':estado', $status);
        } else {
            $this->db->query('SELECT estado, COUNT(*) as count FROM noticias GROUP BY estado');
        }
        
        if ($status) {
            $result = $this->db->single();
            return $result->count;
        } else {
            return $this->db->resultSet();
        }
    }
    
    // Search news with filters
    public function searchNews($filters = [], $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = [];
        
        // Construir la consulta base
        $sql = 'SELECT n.*, u.nombre as autor_nombre, u.apellidos as autor_apellidos 
                FROM noticias n 
                LEFT JOIN users u ON n.autor_id = u.id';
        
        // Aplicar filtros
        if (!empty($filters['search'])) {
            $where[] = '(n.titulo LIKE :search OR n.contenido LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['estado'])) {
            $where[] = 'n.estado = :estado';
            $params[':estado'] = $filters['estado'];
        }
        
        if (!empty($filters['fecha_desde'])) {
            $where[] = 'n.fecha_publicacion >= :fecha_desde';
            $params[':fecha_desde'] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $where[] = 'n.fecha_publicacion <= :fecha_hasta';
            $params[':fecha_hasta'] = $filters['fecha_hasta'];
        }
        
        // Añadir condiciones WHERE si existen
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        
        // Ordenar y paginar
        $sql .= ' ORDER BY n.fecha_publicacion DESC';
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
    
    // Count total news matching search filters
    public function countSearchNews($filters = []) {
        $params = [];
        $where = [];
        
        // Construir la consulta base
        $sql = 'SELECT COUNT(*) as total FROM noticias n';
        
        // Aplicar filtros (mismos que en searchNews)
        if (!empty($filters['search'])) {
            $where[] = '(n.titulo LIKE :search OR n.contenido LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['estado'])) {
            $where[] = 'n.estado = :estado';
            $params[':estado'] = $filters['estado'];
        }
        
        if (!empty($filters['fecha_desde'])) {
            $where[] = 'n.fecha_publicacion >= :fecha_desde';
            $params[':fecha_desde'] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $where[] = 'n.fecha_publicacion <= :fecha_hasta';
            $params[':fecha_hasta'] = $filters['fecha_hasta'];
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
    
    // Update news status
    public function updateNewsStatus($id, $status) {
        $validStatuses = ['publicado', 'borrador', 'archivado'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }
        
        $this->db->query('UPDATE noticias SET estado = :estado, fecha_actualizacion = NOW() WHERE id = :id');
        $this->db->bind(':estado', $status);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Get news statistics for dashboard
    public function getNewsStats() {
        $stats = [];
        
        // Total news
        $this->db->query('SELECT COUNT(*) as total FROM noticias');
        $result = $this->db->single();
        $stats['total'] = $result->total;
        
        // Published news
        $this->db->query('SELECT COUNT(*) as published FROM noticias WHERE estado = "publicado"');
        $result = $this->db->single();
        $stats['published'] = $result->published;
        
        // Draft news
        $this->db->query('SELECT COUNT(*) as draft FROM noticias WHERE estado = "borrador"');
        $result = $this->db->single();
        $stats['draft'] = $result->draft;
        
        // Archived news
        $this->db->query('SELECT COUNT(*) as archived FROM noticias WHERE estado = "archivado"');
        $result = $this->db->single();
        $stats['archived'] = $result->archived;
        
        // News this month
        $this->db->query('SELECT COUNT(*) as this_month FROM noticias WHERE MONTH(fecha_publicacion) = MONTH(NOW()) AND YEAR(fecha_publicacion) = YEAR(NOW())');
        $result = $this->db->single();
        $stats['this_month'] = $result->this_month;
        
        return $stats;
    }
}
