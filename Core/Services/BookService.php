<?php

/**
 *
 */
class BookService
{
    /**
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public function getBookById(int $id): ?array
    {
        $booksManager = ManagerFactory::getBookManager();
        $book = $booksManager->findBookById($id);

        if ($book === null) {
            throw new Exception("Livre introuvable.");
        }

        return $book;
    }

    /**
     * @return array
     */
    public function getAllAvailableBooks(): array
    {
        $booksManager = ManagerFactory::getBookManager();
        return $booksManager->findAllAvailableBooks();
    }

    /**
     * @param int $id
     * @param array $formData
     * @return void
     * @throws Exception
     */
    public function updateBook(int $id, array $formData): void
    {
        $book = $this->getBookById($id);

        if ($book === null) {
            throw new Exception("Livre introuvable.");
        }

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
            $formData['cover'] ?? null,
            $formData['user_id']
        );
    }

    /**
     * @return array
     * @throws Exception
     */
    public function extractBookFormData(): array
    {
        $data = [
            'title' =>  trim(Helpers::getParameter('title', '', 'post')),
            'author' =>  trim(Helpers::getParameter('author', '', 'post')),
            'description' =>  trim(Helpers::getParameter('description', '', 'post')),
            'available' =>  Helpers::getParameter('available', '', 'post'),
            'cover' => 'images/default-cover.svg'
        ];

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
            $fileTmpPath = $_FILES['cover']['tmp_name'];
            $fileName = $_FILES['cover']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadDir = __DIR__ . '/../../public/uploads/';

                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $destPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $data['cover'] = 'uploads/' . $newFileName;
                } else {
                    throw new Exception("Erreur lors de l'upload de l'image.");
                }
            } else {
                throw new Exception("Type de fichier non autorisé. jpg, jpeg, png, gif seulement.");
            }
        }

        return $data;
    }

    /**
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

        if (
            $formData['title'] === $book['title'] &&
            $formData['author'] === $book['author'] &&
            $formData['description'] === $book['description'] &&
            $formData['available'] === (string)$book['available']
        ) {
            throw new Exception("Aucune modification n'a été apportée");
        }
    }
}
