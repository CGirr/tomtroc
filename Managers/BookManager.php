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
                INNER JOIN user u ON b.user_id = u.id
                WHERE b.available = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param $userId
     * @return array|null
     */
    public function findAvailableBooksByUserId($userId): ?array
    {
        $sql = "SELECT * FROM books
                WHERE user_id = :userId
                AND available = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["userId" => $userId]);

        return $stmt->fetchAll();
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function findBookById(int $id): ?array
    {
        $sql = "SELECT b.*, u.login as vendor, u.profile_picture as profile_picture, u.id as vendor_id
                FROM books b
                INNER JOIN user u ON b.user_id = u.id
                WHERE b.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $book = $stmt->fetch();

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

       return $stmt->fetchAll();
   }

    /**
     * @return array
     */
    public function findLastAddedBooks(): array
    {
        $sql = "SELECT b.*, u.login as vendor
                FROM books b
                INNER JOIN user u ON b.user_id = u.id
                WHERE b.available = 1
                ORDER BY created_at DESC 
                LIMIT 4";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
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

    /**
     * @param string $title
     * @param string $author
     * @param string $description
     * @param int $available
     * @param string|null $coverUrl
     * @return void
     */
    public function insertBook(
        string $title,
        string $author,
        string $description,
        int $available,
        ?string $cover,
        int $userId
    ): void {
        $sql = "
        INSERT INTO books 
            (title, author, description, available, cover, created_at, user_id)
        VALUES 
            (:title, :author, :description, :available, :cover, NOW(), :user_id)
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':available' => $available,
            ':cover' => $cover,
            ':user_id' => $userId
        ]);
    }
}
