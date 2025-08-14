<?php

class BookController extends BaseController
{
    /**
     * @var BookService $bookService
     */
    private BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    /**
     * @param string $method
     * @return int
     * @throws Exception
     */
    private function getBookId(string $method = 'get'): int
    {
        $id = Helpers::getParameter('id', null, $method);
        if ($id === null) {
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
        $id = $this->getBookId();
        $book = $this->bookService->getBookById($id);

        $action = Helpers::getParameter('action', 'home', 'get');

        $this->render(
            "singleBook",
            [
                'action' => $action,
                'book' => $book
            ],
            'Détails du livre');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function showAllBooks(): void
    {
        $books = $this->bookService->getAllAvailableBooks();

        $action = Helpers::getParameter('action', 'home', 'get');

        $this->render(
            "allBooks",
            [
                'action' => $action,
                'books' => $books
            ],
            'Tous nos livres'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function showEditBookForm(): void
    {
        Helpers::checkIfUserIsConnected();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = Helpers::getParameter('id', null, 'post');
            $this->handleBookUpdate((int)$id);
            return;
        }

        $id = $this->getBookId();
        $this->renderEditBookForm($id);
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function handleBookUpdate(int $id): void
    {
        $formData = $this->bookService->extractBookFormData();

        try {
            $this->bookService->updateBook($id, $formData);

            $_SESSION['success'] = "Livre mis à jour avec succès !";
            Helpers::redirect("editBook&id=$id");
        } catch (Exception $e) {
            $this->renderEditBookForm($id, $e->getMessage(), $formData);
        }
    }

    /**
     * @param int $id
     * @param string|null $error
     * @param array|null $formData
     * @return void
     * @throws Exception
     */
    public function renderEditBookForm(int $id, string $error = null, array $formData = null): void
    {
        $viewData = $this->bookService->prepareBookEditData($id, $formData, $error);
        $this->render("editBookForm", $viewData, 'Modifier le livre');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function deleteBook(): void
    {
        Helpers::checkIfUserIsConnected();

        $id = $this->getBookId('post');

        $this->bookService->deleteBook($id);

        Helpers::redirect('account');
    }
}
