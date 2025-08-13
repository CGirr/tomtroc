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

        $action = Helpers::getParameter('action', 'home', 'get');
        $view = new View('Home');
        $view->render(
            "home",
            [
                'action' => $action,
                'books' => $books
            ]
        );
    }
}
