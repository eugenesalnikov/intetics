<?php

use ESalnikov\Intetics\Controller\IndexController;
use ESalnikov\Intetics\Core\ConfigParser;
use ESalnikov\Intetics\Core\Database;
use ESalnikov\Intetics\Core\RandomStringGenerator;
use ESalnikov\Intetics\Core\Session;
use ESalnikov\Intetics\Exception\ForbiddenException;
use ESalnikov\Intetics\Repository\MessageRepository;
use ESalnikov\Intetics\Transport\EmailSender;
use ESalnikov\Intetics\Transport\SmsSender;

require_once '../src/Repository/MessageRepository.php';
require_once '../src/Controller/AbstractController.php';
require_once '../src/Controller/IndexController.php';
require_once '../src/Core/RandomStringGenerator.php';
require_once '../src/Core/ConfigParser.php';
require_once '../src/Core/Database.php';
require_once '../src/Core/Session.php';
require_once '../src/Entity/Message.php';
require_once '../src/Exception/ForbiddenException.php';
require_once '../src/Transport/Sender.php';
require_once '../src/Transport/SmsSender.php';
require_once '../src/Transport/EmailSender.php';

$configParser = new ConfigParser();
$database = new Database($configParser);

$controller = new IndexController(
    new RandomStringGenerator(),
    new Session(),
    new MessageRepository($database),
    new SmsSender(),
    new EmailSender()
);

try {
    $controller->defaultAction();
} catch (ForbiddenException $e) {
    header('HTTP/1.0 403 Forbidden');
}
