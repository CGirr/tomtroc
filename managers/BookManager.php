<?php

/**
 * BookManager class that handles all database operations related to the Book entity
 * (creating, updating or deleting books...)
 */
class BookManager extends AbstractEntityManager {
   public function findNumberOfBooks(int $userId) : int
   {
       $sql = $this->db->prepare("SELECT COUNT(*) FROM books WHERE user_id = ?");
       $sql->execute([$userId]);
       return $sql->fetchColumn();
   }

   public function findBooksByUserId(int $userId) : array {
       $sql = $this->db->prepare("SELECT cover, title, author, description, available  FROM books WHERE user_id = ?");
       $sql->execute([$userId]);
       return $sql->fetchAll(PDO::FETCH_ASSOC);
   }

   public function findLastAddedBooks() : array {
       $sql = $this->db->prepare("SELECT * FROM books ORDER BY created_at DESC LIMIT 4");
       $sql->execute();
       return $sql->fetchAll(PDO::FETCH_ASSOC);
   }
}