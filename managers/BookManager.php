<?php

/**
 * BookManager class that handles all database operations related to the Book entity
 * (creating, updating or deleting books...)
 */
class BookManager extends AbstractEntityManager
{

    /**
     * @return array|null
     */
    public function findAllAvailableBooks(): ?array
    {
        $sql = "SELECT b.*, u.login as vendor 
                FROM books b
                JOIN user u ON b.user_id = u.id
                WHERE b.available = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAvailableBooksByUserId($userId): ?array
    {
        $sql = "SELECT * FROM books
                WHERE user_id = :userId
                AND available = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["userId" => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function findBookById(int $id): ?array
    {
        $sql = "SELECT b.*, u.login as vendor, u.profile_picture as profile_picture, u.id as vendor_id
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
        $sql = "SELECT id, cover, title, author, description, available FROM books WHERE user_id = ?";
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

    /**
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id): bool
   {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
   }

    /**
     * @param Book $book
     * @return bool
     */
    public function addBook(Book $book): bool
   {

   }

    /**
     * @param int $id
     * @param string $title
     * @param string $author
     * @param string $description
     * @param string $available
     * @return bool
     */
    public function updateBook(int $id, string $title, string $author, string $description, string $available): bool
   {
        $sql = "UPDATE books SET title = :title, author = :author, description = :description, available = :available
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'available' => $available,
            'id' => $id
        ]);

        if (!$success) {
            return false;
        }

        return $stmt->rowCount() > 0;
   }
}