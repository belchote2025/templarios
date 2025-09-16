<?php

namespace App\Models\Support;

class Faq extends BaseModel {
    protected $table = 'faqs';

    public function __construct() {
        parent::__construct();
    }

    public function search($query, $categoryId = null, $limit = 10, $offset = 0) {
        $sql = "SELECT f.*, c.name as category_name 
                FROM {$this->table} f
                LEFT JOIN faq_categories c ON f.category_id = c.id
                WHERE (f.question LIKE :query OR f.answer LIKE :query)
                AND f.status = 'published'";
        
        $params = [':query' => "%$query%"];
        
        if ($categoryId) {
            $sql .= " AND f.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }
        
        $sql .= " ORDER BY f.views DESC, f.updated_at DESC";
        $sql .= " LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        // Bind parameters with correct types
        $stmt->bindValue(':query', "%$query%", \PDO::PARAM_STR);
        if ($categoryId) {
            $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getByCategory($categoryId, $limit = 10, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE category_id = :category_id 
                AND status = 'published'
                ORDER BY display_order ASC, question ASC
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function incrementViews($id) {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        return $this->executeQuery($sql, [':id' => $id]) !== false;
    }

    public function getFeatured($limit = 5) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE is_featured = 1 
                AND status = 'published'
                ORDER BY updated_at DESC
                LIMIT :limit";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
