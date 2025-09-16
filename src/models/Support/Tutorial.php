<?php

namespace App\Models\Support;

use PDO;
use PDOException;

class Tutorial extends BaseModel
{
    protected $table = 'tutorials';
    
    /**
     * Obtiene todos los tutoriales con paginación
     * 
     * @param array $filters Filtros de búsqueda
     * @param int $page Número de página
     * @param int $perPage Elementos por página
     * @return array
     */
    public function getAll($filters = [], $page = 1, $perPage = 10)
    {
        try {
            $offset = ($page - 1) * $perPage;
            $where = ["status = 'published'"];
            $params = [];
            
            // Aplicar filtros
            if (!empty($filters['category_id'])) {
                $where[] = 'category_id = :category_id';
                $params[':category_id'] = $filters['category_id'];
            }
            
            if (!empty($filters['difficulty'])) {
                $where[] = 'difficulty = :difficulty';
                $params[':difficulty'] = $filters['difficulty'];
            }
            
            if (!empty($filters['search'])) {
                $where[] = '(title LIKE :search OR content LIKE :search)';
                $params[':search'] = "%{$filters['search']}%";
            }
            
            $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
            
            // Consulta para contar el total
            $countQuery = "SELECT COUNT(*) as total FROM {$this->table} $whereClause";
            $countStmt = $this->db->prepare($countQuery);
            $countStmt->execute($params);
            $total = (int) $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Consulta para obtener los resultados
            $query = "
                SELECT t.*, c.name as category_name, c.icon as category_icon
                FROM {$this->table} t
                LEFT JOIN faq_categories c ON t.category_id = c.id
                $whereClause
                ORDER BY t.is_featured DESC, t.created_at DESC
                LIMIT :offset, :limit
            ";
            
            $stmt = $this->db->prepare($query);
            
            // Vincular parámetros
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int) $perPage, PDO::PARAM_INT);
            
            $stmt->execute();
            $tutorials = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'tutorials' => $tutorials,
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($total / $perPage)
            ];
        } catch (PDOException $e) {
            $this->logError($e, 'Error al obtener tutoriales');
            return [
                'tutorials' => [],
                'total' => 0,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => 0
            ];
        }
    }
    
    /**
     * Obtiene un tutorial por su slug
     * 
     * @param string $slug Slug del tutorial
     * @return array|null
     */
    public function getBySlug($slug)
    {
        try {
            $query = "
                SELECT t.*, c.name as category_name, c.icon as category_icon
                FROM {$this->table} t
                LEFT JOIN faq_categories c ON t.category_id = c.id
                WHERE t.slug = :slug AND t.status = 'published'
                LIMIT 1
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError($e, 'Error al obtener tutorial por slug');
            return null;
        }
    }
    
    /**
     * Obtiene tutoriales destacados
     * 
     * @param int $limit Límite de tutoriales a devolver
     * @return array
     */
    public function getFeatured($limit = 5)
    {
        try {
            $query = "
                SELECT t.*, c.name as category_name
                FROM {$this->table} t
                LEFT JOIN faq_categories c ON t.category_id = c.id
                WHERE t.is_featured = 1 AND t.status = 'published'
                ORDER BY t.created_at DESC
                LIMIT :limit
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError($e, 'Error al obtener tutoriales destacados');
            return [];
        }
    }
    
    /**
     * Obtiene tutoriales relacionados
     * 
     * @param int $tutorialId ID del tutorial actual (para excluirlo)
     * @param int $categoryId ID de la categoría para buscar tutoriales relacionados
     * @param int $limit Límite de tutoriales a devolver
     * @return array
     */
    public function getRelated($tutorialId, $categoryId, $limit = 3)
    {
        try {
            $query = "
                SELECT t.*, c.name as category_name
                FROM {$this->table} t
                LEFT JOIN faq_categories c ON t.category_id = c.id
                WHERE t.id != :tutorial_id 
                AND t.category_id = :category_id 
                AND t.status = 'published'
                ORDER BY t.is_featured DESC, t.views DESC, t.created_at DESC
                LIMIT :limit
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':tutorial_id', (int) $tutorialId, PDO::PARAM_INT);
            $stmt->bindValue(':category_id', (int) $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError($e, 'Error al obtener tutoriales relacionados');
            return [];
        }
    }
    
    /**
     * Incrementa el contador de visitas de un tutorial
     * 
     * @param int $id ID del tutorial
     * @return bool
     */
    public function incrementViews($id)
    {
        try {
            $query = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->logError($e, 'Error al incrementar vistas del tutorial');
            return false;
        }
    }
    
    /**
     * Califica un tutorial
     * 
     * @param int $tutorialId ID del tutorial
     * @param int $userId ID del usuario que califica
     * @param bool $isHelpful Si el tutorial fue útil
     * @return bool
     */
    public function rate($tutorialId, $userId, $isHelpful)
    {
        try {
            $this->db->beginTransaction();
            
            // Eliminar calificación previa si existe
            $deleteQuery = "
                DELETE FROM tutorial_ratings 
                WHERE tutorial_id = :tutorial_id AND user_id = :user_id
            ";
            
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->execute([
                ':tutorial_id' => $tutorialId,
                ':user_id' => $userId
            ]);
            
            // Insertar nueva calificación
            $insertQuery = "
                INSERT INTO tutorial_ratings (tutorial_id, user_id, is_helpful, created_at)
                VALUES (:tutorial_id, :user_id, :is_helpful, NOW())
            ";
            
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->execute([
                ':tutorial_id' => $tutorialId,
                ':user_id' => $userId,
                ':is_helpful' => $isHelpful ? 1 : 0
            ]);
            
            // Actualizar contadores en la tabla de tutoriales
            $updateQuery = "
                UPDATE {$this->table} t
                SET 
                    helpful_count = (
                        SELECT COUNT(*) 
                        FROM tutorial_ratings 
                        WHERE tutorial_id = :tutorial_id AND is_helpful = 1
                    ),
                    not_helpful_count = (
                        SELECT COUNT(*) 
                        FROM tutorial_ratings 
                        WHERE tutorial_id = :tutorial_id2 AND is_helpful = 0
                    )
                WHERE t.id = :tutorial_id3
            ";
            
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([
                ':tutorial_id' => $tutorialId,
                ':tutorial_id2' => $tutorialId,
                ':tutorial_id3' => $tutorialId
            ]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al calificar tutorial');
            return false;
        }
    }
    
    /**
     * Crea un nuevo tutorial
     * 
     * @param array $data Datos del tutorial
     * @return int|false ID del nuevo tutorial o false en caso de error
     */
    public function create($data)
    {
        try {
            $query = "
                INSERT INTO {$this->table} (
                    title, slug, content, video_url, thumbnail_url, 
                    duration, difficulty, category_id, status, 
                    is_featured, created_by, updated_by
                ) VALUES (
                    :title, :slug, :content, :video_url, :thumbnail_url, 
                    :duration, :difficulty, :category_id, :status, 
                    :is_featured, :created_by, :updated_by
                )
            ";
            
            $stmt = $this->db->prepare($query);
            
            // Generar slug a partir del título si no se proporciona
            $slug = !empty($data['slug']) ? $data['slug'] : $this->generateSlug($data['title']);
            
            $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindValue(':content', $data['content'], PDO::PARAM_STR);
            $stmt->bindValue(':video_url', $data['video_url'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':thumbnail_url', $data['thumbnail_url'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':duration', $data['duration'] ?? 0, PDO::PARAM_INT);
            $stmt->bindValue(':difficulty', $data['difficulty'] ?? 'beginner', PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
            $stmt->bindValue(':status', $data['status'] ?? 'draft', PDO::PARAM_STR);
            $stmt->bindValue(':is_featured', $data['is_featured'] ?? 0, PDO::PARAM_BOOL);
            $stmt->bindValue(':created_by', $data['created_by'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':updated_by', $data['updated_by'] ?? null, PDO::PARAM_INT);
            
            $this->db->beginTransaction();
            $stmt->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            
            return $id;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al crear tutorial');
            return false;
        }
    }
    
    /**
     * Actualiza un tutorial existente
     * 
     * @param int $id ID del tutorial
     * @param array $data Datos a actualizar
     * @return bool
     */
    public function update($id, $data)
    {
        try {
            $fields = [];
            $params = [':id' => $id];
            
            // Campos actualizables
            $updatableFields = [
                'title', 'slug', 'content', 'video_url', 'thumbnail_url',
                'duration', 'difficulty', 'category_id', 'status',
                'is_featured', 'updated_by'
            ];
            
            foreach ($updatableFields as $field) {
                if (array_key_exists($field, $data)) {
                    $fields[] = "$field = :$field";
                    $params[":$field"] = $data[$field];
                }
            }
            
            // Asegurarse de que hay algo que actualizar
            if (empty($fields)) {
                return true;
            }
            
            // Agregar updated_at
            $fields[] = 'updated_at = NOW()';
            
            $query = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            
            $this->db->beginTransaction();
            $result = $stmt->execute($params);
            $this->db->commit();
            
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al actualizar tutorial');
            return false;
        }
    }
    
    /**
     * Elimina un tutorial
     * 
     * @param int $id ID del tutorial
     * @return bool
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            $this->db->beginTransaction();
            $result = $stmt->execute();
            $this->db->commit();
            
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            $this->logError($e, 'Error al eliminar tutorial');
            return false;
        }
    }
    
    /**
     * Genera un slug a partir de un texto
     * 
     * @param string $text Texto a convertir en slug
     * @return string
     */
    private function generateSlug($text)
    {
        // Reemplazar caracteres especiales
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
        // Transliterar caracteres especiales
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // Eliminar caracteres no deseados
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // Convertir a minúsculas
        $text = strtolower(trim($text, '-'));
        
        // Si el texto está vacío, generar un slug aleatorio
        if (empty($text)) {
            return 'tutorial-' . uniqid();
        }
        
        return $text;
    }
}
