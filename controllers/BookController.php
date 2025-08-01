<?php

/**
 *
 */
class BookController
{
    private function getBookId(string $method = 'get'): int
    {
        $id = Helpers::request('id', null, $method);
        if (!$id) {
            throw new Exception("L'id du livre est manquant");
        }

        return $id;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function showSingleBook(): void
    {
        $id = $this->getBookId('get');
        $booksManager = ManagerFactory::getBookManager();
        $book = $booksManager->findBookById((int)$id);

        if (!$book) {
            throw new Exception("Livre introuvable.");
        }

        $action = Helpers::request('action', 'home', 'get');

        $view = new View('Détails du livre');
        $view->render("singleBook", [
            'action' => $action,
            'book' => $book
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function showAllBooks(): void
    {
        $booksManager = ManagerFactory::getBookManager();
        $books = $booksManager->findAllAvailableBooks();

        $action = Helpers::request('action', 'home', 'get');

        $view = new View('Tous nos livres');
        $view->render("allBooks", [
            'action' => $action,
            'books' => $books
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function showEditBookForm(): void
    {
        Helpers::checkIfUserIsConnected();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = Helpers::request('id', null, 'post');
            $this->handleBookUpdate((int)$id);
            return;
        }

        $id = $this->getBookId('get');
        $this->renderEditBookForm($id);
    }

    public function handleBookUpdate(int $id): void
    {
        $bookManager = ManagerFactory::getBookManager();
        $book = $bookManager->findBookById((int)$id);

        $formData = [
            'title' =>  trim(Helpers::request('title', '', 'post')),
            'author' =>  trim(Helpers::request('author', '', 'post')),
            'description' =>  trim(Helpers::request('description', '', 'post')),
            'available' =>  Helpers::request('available', '', 'post'),
        ];

        if(empty($formData['title']) || empty($formData['author'])) {
            $this->renderEditBookForm($id, "Les champs Titre et Auteur sont obligatoires", $formData);
            return;
        }

        if (!in_array($formData['available'], ['0', '1'], true)) {
            $this->renderEditBookForm($id, "Valeur invalide pour la disponibilité", $formData);
            return;
        }

        if (
            $formData['title'] === $book['title'] &&
            $formData['author'] === $book['author'] &&
            $formData['description'] === $book['description'] &&
            (string)$formData['available'] === (string)$book['available']
        ) {
            $this->renderEditBookForm($id, "Aucune modification n'a été apportée", $formData);
            return;
        }

        $isUpdated = $bookManager->updateBook(
            $id,
            $formData['title'],
            $formData['author'],
            $formData['description'],
            $formData['available']
        );

        if (!$isUpdated) {
            $this->renderEditBookForm($id, "La mise à jour a échoué. Veuillez réessayer.", $formData);
            return;
        }

        $_SESSION['success'] = "Livre mis à jour avec succès !";
        Helpers::redirect("editBook&id=$id");
    }

    public function renderEditBookForm(int $id, string $error = null, array $formData = null): void
    {
        $booksManager = ManagerFactory::getBookManager();
        $book = $booksManager->findBookById($id);

        if(!$book) {
            throw new Exception("Livre introuvable.");
        }

        if ($formData === null) {
            $formData = $book;
        } else {
            $formData = array_merge($book, $formData);
        }

        $viewData = [
            'book' => $formData,
            'error' => $error,
            'success' => $_SESSION['success'] ?? null,
        ];

        unset($_SESSION['success']);

        $view = new View('Modifier le livre');
        $view->render("editBookForm", $viewData);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function deleteBook(): void
    {
        Helpers::checkIfUserIsConnected();

        $id = $this->getBookId('post');
        $booksManager = ManagerFactory::getBookManager();
        $isDeleted = $booksManager->deleteBook($id);

        if (!$isDeleted) {
            throw new Exception("La suppression a échouée ou le livre n'existe pas.");
        }

        Helpers::redirect('account');
    }
}
