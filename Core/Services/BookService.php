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
     * @return array
     */
    public function extractBookFormData(): array
    {
        return [
            'title' =>  trim(Helpers::getParameter('title', '', 'post')),
            'author' =>  trim(Helpers::getParameter('author', '', 'post')),
            'description' =>  trim(Helpers::getParameter('description', '', 'post')),
            'available' =>  Helpers::getParameter('available', '', 'post'),
        ];
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
