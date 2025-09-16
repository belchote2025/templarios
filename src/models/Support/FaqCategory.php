<?php

namespace App\Models\Support;

use PDO;
use PDOException;

class FaqCategory extends BaseModel
{
    protected $table = 'faq_categories';
    
    /**
     * Obtiene todas las categorías
     * 
     * @param bool $withCount Si es true, incluye el recuento de FAQs por categoría
     * @return array
     */
    public function getAll($withCount = false)
    {
        try {
            $query = "SELECT * FROM {$this->table} ORDER BY display_order ASC, name ASC";
            $stmt = $this->db->query($query);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($withCount) {
                foreach ($categories as &$category) {
                    $category['faq_count'] = $this->getFaqCount($category['id']);
                }
                unset($category); // Rompe la referencia
            }
            
            return $categories;
        } catch (PDOException $e) {
            $this->logError($e, 'Error al obtener categorías de FAQ');
            return [];
        }
    }
    
    /**
     * Obtiene una categoría por su ID
     * 
     * @param int $id ID de la categoría
     * @return array|null
     */
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError($e, 'Error al obtener categoría por ID');
            return null;
        }
    }
    
    /**
     * Crea una nueva categoría
     * 
     * @param array $data Datos de la categoría
     * @return int|false ID de la nueva categoría o false en caso de error
     */
    public function create($data)
    {
        try {
            $query = "
                INSERT INTO {$this->table} (name, description, icon, display_order)
                VALUES (:name, :description, :icon, :display_order)
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':icon', $data['icon'], PDO::PARAM_STR);
            $stmt->bindValue(':display_order', $data['display_order'] ?? 0, PDO::PARAM_INT);
            
            $this->db->beginTransaction();
            $stmt->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            
            return $id;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al crear categoría de FAQ');
            return false;
        }
    }
    
    /**
     * Actualiza una categoría existente
     * 
     * @param int $id ID de la categoría
     * @param array $data Datos a actualizar
     * @return bool
     */
    public function update($id, $data)
    {
        try {
            $fields = [];
            $params = [':id' => $id];
            
            if (isset($data['name'])) {
                $fields[] = 'name = :name';
                $params[':name'] = $data['name'];
            }
            
            if (isset($data['description'])) {
                $fields[] = 'description = :description';
                $params[':description'] = $data['description'];
            }
            
            if (isset($data['icon'])) {
                $fields[] = 'icon = :icon';
                $params[':icon'] = $data['icon'];
            }
            
            if (isset($data['display_order'])) {
                $fields[] = 'display_order = :display_order';
                $params[':display_order'] = $data['display_order'];
            }
            
            if (empty($fields)) {
                return true; // No hay nada que actualizar
            }
            
            $query = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            
            $this->db->beginTransaction();
            $result = $stmt->execute($params);
            $this->db->commit();
            
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al actualizar categoría de FAQ');
            return false;
        }
    }
    
    /**
     * Elimina una categoría
     * 
     * @param int $id ID de la categoría
     * @return bool
     */
    public function delete($id)
    {
        try {
            // Verificar si hay FAQs asociadas
            $faqCount = $this->getFaqCount($id);
            if ($faqCount > 0) {
                throw new PDOException('No se puede eliminar la categoría porque tiene FAQs asociadas');
            }
            
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            $this->db->beginTransaction();
            $result = $stmt->execute();
            $this->db->commit();
            
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al eliminar categoría de FAQ');
            return false;
        }
    }
    
    /**
     * Obtiene el recuento de FAQs en una categoría
     * 
     * @param int $categoryId ID de la categoría
     * @return int
     */
    private function getFaqCount($categoryId)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM faqs WHERE category_id = :category_id AND status = 'published'";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['count'];
        } catch (PDOException $e) {
            $this->logError($e, 'Error al contar FAQs por categoría');
            return 0;
        }
    }
}
