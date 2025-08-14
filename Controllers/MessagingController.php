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
       $params = [
           "conversations" => $this->conversationService->getUserConversations($currentUserId),
       ];

       $conversationId = isset($_GET['id']) ? (int)$_GET['id'] : null;

       if ($conversationId !== null) {
           $this->getConversationOrFail($conversationId, $currentUserId);

           $this->messageService->markMessagesAsRead($conversationId, $currentUserId);

           $params["messages"] = $this->messageService->getMessagesByConversationId($conversationId, $currentUserId);
       }

       $this->render('messaging', $params, 'Messagerie');
   }

   public function getConversationOrFail(int $conversationId, int $currentUserId): Conversation
   {
       $conversation = ManagerFactory::getConversationManager()->findConversationById($conversationId);

       if (!$conversation) {
           throw new Exception("Conversation introuvable", 404);
       }

       if (!$conversation->hasParticipant($currentUserId)) {
           throw new Exception("Accès refusé à cette conversation", 403);
       }

       return $conversation;
   }

    /**
     * @return void
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
}
