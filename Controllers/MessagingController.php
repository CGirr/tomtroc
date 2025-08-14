<?php

class MessagingController extends BaseController
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
        parent::__construct();
        $this->conversationService = new ConversationService();
        $this->messageService = new MessageService();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function showMessagingPage(): void
   {
       Helpers::checkIfUserIsConnected();

       $this->renderMessagingView($this->currentUserId);
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
       ];

       if (isset($_GET['id'])) {
           $conversationId = $_GET['id'];

           $this->messageService->markMessagesAsRead($conversationId, $currentUserId);

           $messages = $this->messageService->getMessagesByConversationId($conversationId, $currentUserId);
           $params["messages"] = $messages;
       }

       $this->render('messaging', $params, 'Messagerie');
   }

    /**
     * @return void
     */
    public function sendMessage()
    {
        $conversationId = (int)$_POST['conversation_id'];
        $senderId = $this->currentUserId;
        $content = trim($_POST['content']);

        if ($conversationId && $senderId && $content !== '') {
            $this->messageService->sendMessage($conversationId, $senderId, $content);
        }

        header('Location: index.php?action=messaging&id=' . $conversationId);
        exit;
    }
}
