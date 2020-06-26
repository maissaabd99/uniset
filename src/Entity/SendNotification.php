<?php


namespace App\Entity;


class SendNotification
{
    private $message;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
    private $recipients;
    public function __construct(string $message,array $recipients=[])
    {
        $this->message=$message;
        $this->recipients=$recipients;
    }

}