<?php

/**
 *
 */
class BookController
{

    /**
     * @return array|null
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
        $view = new View('Single Livre');
        $view->render("singleBook",[
            'action' => $action,
            'book' => $book
        ]);
    }
}
