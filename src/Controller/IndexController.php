<?php

namespace ESalnikov\Intetics\Controller;

use ESalnikov\Intetics\Core\RandomStringGenerator;
use ESalnikov\Intetics\Core\Session;
use ESalnikov\Intetics\Exception\ForbiddenException;
use ESalnikov\Intetics\Repository\MessageRepository;
use ESalnikov\Intetics\Transport\EmailSender;
use ESalnikov\Intetics\Transport\SmsSender;
use Exception;

class IndexController extends AbstractController
{
    private RandomStringGenerator $stringGenerator;
    private Session               $session;

    private MessageRepository $messageRepository;

    private EmailSender $emailSender;

    private SmsSender $smsSender;

    public function __construct(
        RandomStringGenerator $stringGenerator,
        Session               $session,
        MessageRepository     $messageRepository,
        SmsSender $smsSender,
        EmailSender $emailSender
    ) {
        $this->stringGenerator = $stringGenerator;
        $this->session = $session;
        $this->messageRepository = $messageRepository;
        $this->smsSender = $smsSender;
        $this->emailSender = $emailSender;
    }

    /**
     * @throws ForbiddenException
     */
    public function defaultAction(): void
    {
        if (empty($_POST)) {
            $csrfToken = $this->stringGenerator->generate();
            $this->session->set('csrfToken', $csrfToken);

            $params = ['token' => $csrfToken];

            $lastInsertedId = $this->session->get('lastId');

            if ($lastInsertedId) {
                $params['message'] = $this->messageRepository->findOneById($lastInsertedId);
                $this->session->unset('lastId');
            }

            $this->render('index.html.php', $params);
        } else {
            $this->sendFormAction($_POST);
        }
    }

    /**
     * @throws ForbiddenException
     */
    public function sendFormAction(array $post)
    {
        $sessionToken = $this->session->get('csrfToken');
        $postToken = $post['csrfToken'] ?? '';

        $this->session->unset('csrfToken');

        if ($sessionToken !== $postToken) {
            throw new ForbiddenException('Csrf token is wrong of not sent.');
        }

        $id = $this->messageRepository->insert($post);
        $this->session->set('lastId', $id);

        $this->smsSender->sendMessage($post['text']);
        $this->emailSender->sendMessage($post['text']);

        header('Location: https://localhost/intetics');
    }
}
