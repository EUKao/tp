<?php 
require_once 'class/Message.php';
require_once 'class/GuestBook.php';
$errors = null;
$success = false;
$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR. 'messages');
if (isset($_POST['username'], $_POST['message'])) {
    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isValid()){
        $guestbook->addMessage($message);
        $success = true;
        $_POST = [];
    } else {
        $errors = $message->getErrors();
    };

}
$messages = $guestbook->getMessages();
$title = "Livre d'or";
require 'elements/header.php';
?>

<div class="container">
    <h1>Livre d'or</h1>

   <!-- Vérification des erreurs -->
   <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            Formulaire invalide mon reuf
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            Cimer !
        </div>
    <?php endif; ?>

   <!-- Formulaire -->
    <form action="" method="post">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '')?>" type="text" name="username" placeholder="Votre pseudo" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
            <!-- Vérification du champ username -->
            <?php if(isset($errors['username'])): ?>
            <div class="invalid-feedback"><?= $errors['username']?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Votre message" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
            <!-- Vérification du champ message -->
            <?php if(isset($errors['message'])): ?>
            <div class="invalid-feedback"><?= $errors['message']?></div>
            <?php endif; ?>
        </div>
        <button class="btn btn-primary" type="submit">Envoyer</button>
    </form>
    
   <!-- Historique des messages -->    
    <?php if (!empty($messages)): ?>
    <h1 class="mt-4">Vos messages</h1>
    
    <?php foreach($messages as $message): ?>
        <?= $message->toHTML() ?>

    <?php endforeach ?>
    
    <?php endif ?>
</div>
<h1>SALUT GAWAIS</h1>
<h2>SALUT SNAGA</h2>
<?php
require 'elements/footer.php';
?>