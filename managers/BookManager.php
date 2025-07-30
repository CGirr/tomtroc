<?php

/**
 * BookManager class that handles all database operations related to the Book entity
 * (creating, updating or deleting books...)
 */
class BookManager extends AbstractEntityManager
{

    public function findAllBooks(): ?array
    {
        $sql = "SELECT b.*, u.login as vendor
                FROM books b
                JOIN users u ON b.user_id = u.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function findBookById(int $id): ?array
    {
        $sql = "SELECT b.*, u.login as vendor, u.profile_picture as profile_picture
                FROM books b
                JOIN user u ON b.user_id = u.id
                WHERE b.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book ?: null;
    }

    /**
     * @param int $userId
     * @return int
     */
    public function findNumberOfBooks(int $userId): int
   {
       $stmt = $this->db->prepare("SELECT COUNT(*) FROM books WHERE user_id = ?");
       $stmt->execute([$userId]);

       return $stmt->fetchColumn();
   }

    /**
     * @param int $userId
     * @return array
     */
    public function findBooksByUserId(int $userId): array
    {
        $sql = "SELECT cover, title, author, description, available FROM books WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);

       return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

    /**
     * @return array
     */
    public function findLastAddedBooks(): array
    {
        $sql = "SELECT b.*, u.login as vendor
                FROM books b
                JOIN user u ON b.user_id = u.id
                ORDER BY created_at DESC 
                LIMIT 4";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
}