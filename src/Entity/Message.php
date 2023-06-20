<?php

namespace ESalnikov\Intetics\Entity;

class Message
{
    private $id;

    private $text;

    public function __construct(array $data)
    {
        $this->setId($data['id'])
            ->setText($data['text']);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Message
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
}
