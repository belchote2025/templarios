<?php

class Product {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    /**
     * Obtener todos los productos
     */
    public function getAllProducts() {
        $this->db->query('SELECT p.*, c.nombre as categoria_nombre 
                         FROM productos p 
                         LEFT JOIN categorias c ON p.categoria_id = c.id 
                         ORDER BY p.id DESC');
        
        return $this->db->resultSet();
    }
    
    /**
     * Crear un nuevo producto
     */
    public function createProduct($data) {
        $this->db->query('INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, activo, fecha_creacion) 
                         VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :activo, NOW())');
        
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion'] ?? '');
        $this->db->bind(':precio', $data['precio']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':categoria_id', $data['categoria_id']);
        $this->db->bind(':activo', $data['activo']);
        
        return $this->db->execute();
    }
    
    /**
     * Obtener un producto por ID
     */
    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.nombre as categoria_nombre 
                         FROM productos p 
                         LEFT JOIN categorias c ON p.categoria_id = c.id 
                         WHERE p.id = :id');
        
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    /**
     * Actualizar un producto
     */
    public function updateProduct($id, $data) {
        $this->db->query('UPDATE productos 
                         SET nombre = :nombre, 
                             descripcion = :descripcion, 
                             precio = :precio, 
                             stock = :stock, 
                             categoria_id = :categoria_id, 
                             activo = :activo,
                             fecha_actualizacion = NOW()
                         WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':descripcion', $data['descripcion'] ?? '');
        $this->db->bind(':precio', $data['precio']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':categoria_id', $data['categoria_id']);
        $this->db->bind(':activo', $data['activo']);
        
        return $this->db->execute();
    }
    
    /**
     * Eliminar un producto
     */
    public function deleteProduct($id) {
        $this->db->query('DELETE FROM productos WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Obtener categorías
     */
    public function getCategories() {
        $this->db->query('SELECT * FROM categorias ORDER BY nombre');
        return $this->db->resultSet();
    }
    
    /**
     * Contar productos
     */
    public function countProducts() {
        $this->db->query('SELECT COUNT(*) as total FROM productos');
        $result = $this->db->single();
        return $result->total ?? 0;
    }
}
