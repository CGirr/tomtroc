<?php

class HomeController
{
    /**
     * Displays home page
     * @return void
     * @throws Exception
     */
    public function showHome() : void
    {
        $booksManager = ManagerFactory::getBookManager();
        $books = $booksManager->findLastAddedBooks();

        $action = Helpers::request('action', 'home', 'get');
        $view = new View('Home');
        $view->render("home", [
            'action' => $action,
            'books' => $books
        ]);
    }
}
