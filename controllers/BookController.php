<?php

/**
 *
 */
class BookController
{

    /**
     * @return void
     * @throws Exception
     */
    public function showSingleBook(): void
    {
        $id = Helpers::request('id', null, 'get');

        if(!$id) {
            throw new Exception("L'id du livre est manquant");
        }

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
        $books = $booksManager->findAllBooks();

        $action = Helpers::request('action', 'home', 'get');

        $view = new View('Tous nos livres');
        $view->render("allBooks", [
            'action' => $action,
            'books' => $books
        ]);
    }
}
