<?php

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

    public function __construct()
    {
        if (Helpers::isUserLoggedIn()) {
            $this->currentUserId = Helpers::getCurrentUserId();

            $messageService = new MessageService();
            $this->unreadMessagesCount = $messageService->countUnreadMessages($this->currentUserId);
        }
    }

    /**
     * @throws Exception
     */
    protected function render(string $viewName, array $params = [], string $title = ''): void
    {
        $params["currentUserId"] = $this->currentUserId ?? null;
        $params['unreadMessagesCount'] = $this->unreadMessagesCount ?? 0;

        $view = new View($title ?: $viewName);
        $view->render($viewName, $params);
    }
}