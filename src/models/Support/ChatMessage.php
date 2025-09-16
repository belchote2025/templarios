<?php

namespace App\Models\Support;

class ChatMessage extends BaseModel {
    protected $table = 'chat_messages';

    public function __construct() {
        parent::__construct();
    }

    public function getConversation($userId, $limit = 20, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function markAsRead($messageIds) {
        if (empty($messageIds)) return false;
        
        $placeholders = rtrim(str_repeat('?,', count($messageIds)), ',');
        $sql = "UPDATE {$this->table} 
                SET is_read = 1 
                WHERE id IN ($placeholders)";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($messageIds);
    }

    public function getUnreadCount($userId) {
        $sql = "SELECT COUNT(*) as count 
                FROM {$this->table} 
                WHERE user_id = :user_id 
                AND is_read = 0";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result ? $result->count : 0;
    }

    public function createMessage($userId, $message, $isFromAdmin = false) {
        $sql = "INSERT INTO {$this->table} 
                (user_id, message, is_from_admin) 
                VALUES (:user_id, :message, :is_from_admin)";
                
        $params = [
            ':user_id' => $userId,
            ':message' => $message,
            ':is_from_admin' => $isFromAdmin ? 1 : 0
        ];
        
        return $this->executeQuery($sql, $params) ? $this->lastInsertId() : false;
    }
}
