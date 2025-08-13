<?php

class MessagingController
{
    /**
     * @var ConversationService
     */
    private ConversationService $conversationService;

    /**
     * @var MessageService
     */
    private MessageService $messageService;

    public function __construct()
    {
        $this->conversationService = new ConversationService();
        $this->messageService = new MessageService();
    }

    /**
     * @param int $userId
     * @return void
     * @throws Exception
     */
    public function showMessagingPage(): void
   {
       Helpers::checkIfUserIsConnected();
       $currentUserId = Helpers::getCurrentUserId();

       $this->renderMessagingView($currentUserId);
   }

    /**
     * @param int $currentUserId
     * @return void
     * @throws Exception
     */
    public function renderMessagingView(int $currentUserId): void
   {
       $conversations = $this->conversationService->getUserConversations($currentUserId);

       $params = [
           "conversations" => $conversations,
           "currentUserId" => $currentUserId,
       ];

       if (isset($_GET['id'])) {
           $messages = $this->messageService->getMessagesByConversationId($_GET['id'], $currentUserId);
           $params["messages"] = $messages;
       }

       $view = new View('Messagerie');
       $view->render('messaging', $params);
   }

    /**
     * @return void
     */
    public function sendMessage()
    {
        $conversationId = (int)$_POST['conversation_id'];
        $senderId = $_SESSION['user']['id'];
        $content = trim($_POST['content']);

        if ($conversationId && $senderId && $content !== '') {
            $this->messageService->sendMessage($conversationId, $senderId, $content);
        }

        header('Location: index.php?action=messaging&id=' . $conversationId);
        exit;
    }
}
