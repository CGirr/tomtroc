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
     * Displays the messaging interface for the current user
     * @return void
     * @throws Exception
     */
    public function showMessagingPage(): void
   {
       Helpers::checkIfUserIsConnected();

       $this->renderMessagingView($this->currentUserId);
   }

    /**
     * Prepares data and renders the messaging view
     * @param int $currentUserId
     * @return void
     * @throws Exception
     */
    public function renderMessagingView(int $currentUserId): void
   {
       $params = [
           "conversations" => $this->conversationService->getUserConversations($currentUserId),
           "conversation" => null,
           "messages"
       ];

       $conversationId = isset($_GET['id']) ? (int)$_GET['id'] : null;

       if ($conversationId !== null) {
           $conversation = $this->conversationService->getConversationOrFail($conversationId, $currentUserId);
           $params["conversation"] = $conversation;

           $this->messageService->markMessagesAsRead($conversationId, $currentUserId);
           $params["messages"] = $this->messageService->getMessagesByConversationId($conversationId, $currentUserId);
       }

       $this->render('messaging', $params, 'Messagerie');
   }



    /**
     * Handles sending a new message in a conversation
     * @return void
     * @throws Exception
     */
    public function sendMessage(): void
    {
        Helpers::checkIfUserIsConnected();

        $conversationId = (int)$_POST['conversation_id'] ?? 0;
        $senderId = $this->currentUserId;
        $content = trim($_POST['content'] ?? '');

        $this->messageService->sendMessage($conversationId, $senderId, $content);

        header('Location: index.php?action=messaging&id=' . $conversationId);
        exit;
    }

    /**
     * Starts a new conversation between the current user and another user
     * @return void
     * @throws Exception
     */
    public function startConversation(): void
    {
        Helpers::checkIfUserIsConnected();

        $sellerId = Helpers::getParameter('id', null, 'get');
        $currentUserId = $this->currentUserId;

        $conversation = $this->conversationService->startOrGetConversation($sellerId, $currentUserId);

        header('Location: index.php?action=messaging&id=' . $conversation->getId());
        exit;
    }
}
