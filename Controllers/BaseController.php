<?php

/**
 * Abstract controller that provides shared functionality for all controllers,
 * storing current user's ID, counting unread messages and rendering views
 */
abstract class BaseController
{
    /**
     * @var int|null
     */
    protected ?int $currentUserId = null;

    /**
     * @var int
     */
    protected int $unreadMessagesCount = 0;

    /**
     * BaseController constructor.
     *
     * Initializes the current user context and retrieves the unread messages count
     * if the user is logged in.
     */
    public function __construct()
    {
        if (Helpers::isUserLoggedIn()) {
            $this->currentUserId = Helpers::getCurrentUserId();

            $messageService = new MessageService();
            $this->unreadMessagesCount = $messageService->countUnreadMessages($this->currentUserId);
        }
    }

    /**
     *  Renders a view with the provided parameters and page title.
     *
     *  Automatically injects current user information (ID and unread messages count) and the action
     *  into the view parameters.
     * @throws Exception
     */
    protected function render(string $viewName, array $params = [], string $title = ''): void
    {
        $params['currentUserId'] = $this->currentUserId ?? null;
        $params['unreadMessagesCount'] = $this->unreadMessagesCount ?? 0;

        if(!isset($params['action'])) {
            $params['action'] = $_GET['action'] ?? null;
        }

        $view = new View($title ?: $viewName);
        $view->render($viewName, $params);
    }
}