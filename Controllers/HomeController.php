<?php

class HomeController extends BaseController
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
        $this->render(
            'home',
            [
                'action' => $action,
                'books' => $books
            ],
            'Accueil'
        );
    }
}
