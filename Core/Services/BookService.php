<?php

/**
 *
 */
class BookService
{
    /**
     * Finds a book by ID
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getBookById(int $id): array
    {
        $booksManager = ManagerFactory::getBookManager();
        $book = $booksManager->findBookById($id);

        if ($book === null) {
            throw new Exception("Livre introuvable.", 404);
        }

        return $book;
    }

    /**
     * Check if book belongs to the current user
     * @param int $id
     * @param int $currentUserId
     * @return array
     * @throws Exception
     */
    public function getBookForUser(int $id, int $currentUserId): array
    {
        $book = $this->getBookById($id);

        if ($book['user_id'] !== $currentUserId) {
            throw new Exception("Accès refusé", 403);
        }

        return $book;
    }

    /**
     * Returns all books that are marked as available
     * @return array
     */
    public function getAllAvailableBooks(): array
    {
        $booksManager = ManagerFactory::getBookManager();
        return $booksManager->findAllAvailableBooks();
    }

    /**
     * Updates an existing book with new form data
     * @param int $id
     * @param array $formData
     * @return void
     * @throws Exception
     */
    public function updateBook(int $id, array $formData): void
    {
        $book = $this->getBookById($id);
        $this->validateFormData($formData, $book);

        $bookManager = ManagerFactory::getBookManager();
        $isUpdated = $bookManager->updateBook(
            $id,
            $formData['title'],
            $formData['author'],
            $formData['description'],
            $formData['available']
        );

        if (!$isUpdated) {
            throw new Exception("La mise à jour a échoué. Veuillez réessayer.");
        }
    }

    /**
     * Deletes a book from the database
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function deleteBook(int $id): void
    {
        $bookManager = ManagerFactory::getBookManager();
        $isDeleted = $bookManager->deleteBook($id);

        if (!$isDeleted) {
            throw new Exception("La suppression a échouée ou le livre n'existe pas.");
        }
    }

    /**
     * Adds a new book to the database
     * @param array $formData
     * @return void
     * @throws Exception
     */
    public function addBook(array $formData): void
    {
        $this->validateFormData($formData, []);

        $bookManager = ManagerFactory::getBookManager();
        $bookManager->insertBook(
            $formData['title'],
            $formData['author'],
            $formData['description'],
            $formData['available'],
            $formData['cover'] ?? 'images/default-cover.svg',
            $formData['user_id']
        );
    }


    /**
     * Extracts and validates form data from a POST request, including file uploads
     * @return array{data: array, error: string|null}
     */
    public function extractBookFormData(): array
    {
        $data = [
            'title' =>  trim(Helpers::getParameter('title', '', 'post')),
            'author' =>  trim(Helpers::getParameter('author', '', 'post')),
            'description' =>  trim(Helpers::getParameter('description', '', 'post')),
            'available' =>  Helpers::getParameter('available', '1', 'post'),
            'cover' => 'images/default-cover.svg'
        ];

        $error = null;

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
            $fileTmpPath = $_FILES['cover']['tmp_name'];
            $fileName = $_FILES['cover']['name'];
            $fileSize = $_FILES['cover']['size'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $maxFileSize = 5 * 1024 * 1024;

            if (!in_array($fileExtension, $allowedExtensions)) {
                $error = "Type de fichier non autorisé. jpg, jpeg, et png uniquement.";
            } elseif (!getimagesize($fileTmpPath)) {
                $error = "Le fichier n'est pas une image valide.";
            } elseif ($fileSize > $maxFileSize) {
                $error = "Fichier trop volumineux. Taille maximum 5MB.";
            } else {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadDir = __DIR__ . '/../../public/uploads/';

                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $destPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $data['cover'] = 'uploads/' . $newFileName;
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            }
        }

        return ['data' => $data, 'error' => $error];
    }

    /**
     * Prepares book data for the edit form view
     * @param int $id
     * @param array|null $formData
     * @param string|null $error
     * @return array
     * @throws Exception
     */
    public function prepareBookEditData(int $id, array $formData = null, ?string $error = null): array
    {
        $book = $this->getBookById($id);

        if ($formData === null) {
            $formData = $book;
        } else {
            $formData = array_merge($book, $formData);
        }

        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);

        return [
            'book' => $formData,
            'error' => $error,
            'success' => $success,
        ];
    }

    /**
     * Validates form input before adding or updating a book
     * @param array $formData
     * @param array $book
     * @return void
     * @throws Exception
     */
    private function validateFormData(array $formData, array $book): void
    {
        if(empty($formData['title']) || empty($formData['author'])) {
            throw new Exception("Les champs Titre et Auteur sont obligatoires");
        }

        if (!in_array($formData['available'], ['0', '1'], true)) {
            throw new Exception("Valeur invalide pour la disponibilité");
        }

        if (!empty($book) &&
            $formData['title'] === $book['title'] &&
            $formData['author'] === $book['author'] &&
            $formData['description'] === $book['description'] &&
            $formData['available'] === (string)$book['available']
        ) {
            throw new Exception("Aucune modification n'a été apportée");
        }
    }
}
