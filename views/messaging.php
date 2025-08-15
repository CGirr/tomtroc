<?php
/**
 * @var $conversations ConversationModel[]
 * @var $messages MessageModel[]
 * @var $conversation ConversationModel|null
 */
?>

<section class="messaging-container">
    <article class="conversations-container">
        <h3>Messagerie</h3>
        <?php foreach ($conversations as $conv): ?>
            <a href="index.php?action=messaging&id=<?= $conv->getId() ?>" class="conversations-cards-container">
                <img
                        src="<?= Helpers::sanitizeUrl($conv->getOtherParticipantProfilePicture()) ?>"
                        alt="Photo de profil du correspondant"
                >
                <div class="conversation-info">
                    <div class="conversation-top">
                        <span class="inter-text conversation-name">
                            <?= Helpers::sanitize($conv->getOtherParticipantName()) ?>
                        </span>
                        <span class="medium-text conversation-date">
                            <?= Helpers::sanitizeUrl($conv->getFormattedCreatedAt()) ?>
                        </span>
                    </div>
                    <div class="medium-text light-grey-text conversation-last-message">
                        <?php if ($conv->getLastMessage()): ?>
                            <?= Helpers::sanitize($conv->getLastMessage()->getContent()) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </article>
   <article class="messages-container">
       <?php if (isset($_GET['id'])): ?>
       <div class="messages-sender-info">
           <img
                   src="<?= $conversation->getOtherParticipantProfilePicture() ?>"
                   alt="Photo de profil du correspondant"
           >
           <span class="inter-tex bold-text"><?= $conversation->getOtherParticipantName() ?></span>
       </div>
       <div class="messages">
           <?php foreach ($messages as $message): ?>
           <div class="message <?= $message->getIsMine() ? 'mine' : 'theirs' ?>">
                   <div class="message-info">
                       <?php if (!$message->getIsMine()): ?>
                           <img
                                   src="<?= Helpers::sanitizeUrl($conversation->getOtherParticipantProfilePicture()) ?>"
                                   alt="Photo de profil de l'envoyeur"
                           >
                       <?php endif; ?>
                       <span class="light-grey-text medium-text"><?= $message->getFormattedSentAt() ?></span>
                   </div>
                   <div class="message-content medium-text">
                       <?= Helpers::sanitize($message->getContent()); ?>
                   </div>
           </div>
           <?php endforeach; ?>
           <form class="message-form" method="post" action="index.php?action=sendMessage">
               <input
                       type="text"
                       name="content"
                       aria-label="Message"
                       placeholder="Tapez votre message ici"
                       class="light-grey-text inter-text"
                       required
               >
               <input type="hidden" name="conversation_id" value="<?= (int)$_GET['id'] ?>" >
               <button type="submit" class="green-button button-text">Envoyer</button>
           </form>
       </div>
       <?php endif; ?>
   </article>
</section>


