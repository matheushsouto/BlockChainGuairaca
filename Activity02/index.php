<?php

require_once("ssl.php");

class ActivityBlockChain
{

    private $people = [
        'Chase',
        'Rennie',
        'Franklin',
        'Huynh',
        'England',
        'Lugo',
        'Rodrigues',
        'Betts',
        'Cummings',
        'Irwin',
        'Nixon',
        'Higgins',
        'Cook',
        'Ross',
        'Eaton',
        'Fountain'
    ];
    private $messages = [];
    private $ssl;

    public function __construct()
    {
        $this->messages = glob('Mensagens/*.txt');
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getPeople()
    {
        return $this->people;
    }

    public function getRecipient($value)
    {
        $initial = strpos($value, 'h ');
        $interval = 2;
        $end = strpos($value, '. ');
        $data = substr($value, ($initial + $interval), ($end - ($initial + $interval)));
        return $data;
    }

    public function getSender($value)
    {
        $initial = strpos($value, ': ');
        $interval = 2;
        $senderMessage = substr($value, ($initial + $interval));
        return $senderMessage;
    }

    public function getSsl()
    {
        $this->ssl = new ssl();
        return $this->ssl;
    }

    function createWriteBlock($archive, $content, $sender, $recipient, $realsender, $block)
    {
        $message =
            "Archive: "     . $archive . PHP_EOL .
            "Content: "     . $content . PHP_EOL .
            "Sender:  "     . $sender . PHP_EOL .
            "Recipient "    . $recipient . PHP_EOL .
            "Real Sender "  . $realsender;

        file_put_contents("blocks/block-" . $block . ".txt", $message);
    }

}

$activity = new ActivityBlockChain();
$messages = $activity->getMessages();
$ssl = $activity->getSsl();
$peoples = $activity->getPeople();

foreach ($messages as $message) {
    $messageBase64 = file_get_contents($message);
    $messageRSA = base64_decode($messageBase64);

    foreach ($peoples as $dispatcher) {
        $privateKey = file_get_contents("Chaves/{$dispatcher}_private_key.pem");
        $publicKey = file_get_contents("Publicas/{$dispatcher}_public_key.pem");
        if ($messageDecrypted = $ssl->decryptItem($messageRSA, $privateKey, 'private')) {
            echo $message;
            $activity->createWriteBlock
            (
                $message, $messageDecrypted,
                $activity->getSender($messageDecrypted),
                $activity->getRecipient($messageDecrypted),
                $dispatcher,
                $message
            );
        }
    }
}
