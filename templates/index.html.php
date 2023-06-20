<?php
/** @var string $token */
/** @var Message $message */
use ESalnikov\Intetics\Entity\Message;
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
</head>
<body>

<?php if (isset($message)):?>
<h3>Your message successfully sent!</h3>
<?php endif; ?>

<form action="" method="post">
    <label for="text">Enter your text</label><textarea name="text" id="text" cols="30" rows="10"><?php if (isset($message)) {
            echo htmlspecialchars($message->getText());
        } ?></textarea>
    <input type="hidden" name="csrfToken" value="<?= $token ?>">
    <input type="submit" value="OK">
</form>
</body>
</html>
