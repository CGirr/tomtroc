<?php

class BookService
{
    public function getBookById(int $id): ?array
    {
        $booksManager = ManagerFactory::getBookManager();
        $book = $booksManager->findBookById((int)$id);

        if (!$book) {
            throw new Exception("Livre introuvable.");
        }

        return $book;
    }

    public function getAllAvailableBooks(): array
    {
        $booksManager = ManagerFactory::getBookManager();
        return $booksManager->findAllAvailableBooks();
    }

    public function updateBook(int $id, array $formData): void
    {
        $bookManager = ManagerFactory::getBookManager();
        $book = $bookManager->findBookById($id);

        if (!$book) {
            throw new Exception("Livre introuvable.");
        }

        if(empty($formData['title']) || empty($formData['author'])) {
            $this->renderEditBookForm($id, "Les champs Titre et Auteur sont obligatoires", $formData);
        }

        if (!in_array($formData['available'], ['0', '1'], true)) {
            $this->renderEditBookForm($id, "Valeur invalide pour la disponibilité", $formData);
        }

        if (
            $formData['title'] === $book['title'] &&
            $formData['author'] === $book['author'] &&
            $formData['description'] === $book['description'] &&
            (string)$formData['available'] === (string)$book['available']
        ) {
            throw new Exception("Aucune modification n'a été apportée");
        }

        $isUpdated = $bookManager->updateBook(
            $id,
            $formData['title'],
            $formData['author'],
            $formData['description'],
            $formData['available']
        );

        if (!$isUpdated) {
            throw new Exception($id, "La mise à jour a échoué. Veuillez réessayer.");
        }
    }

    public function deleteBook(int $id): void
    {
        $bookManager = ManagerFactory::getBookManager();
        $isDeleted = $bookManager->deleteBook($id);

        if (!$isDeleted) {
            throw new Exception("La suppression a échouée ou le livre n'existe pas.");
        }
    }
}
