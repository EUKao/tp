<?php
require_once 'Message.php';

class GuestBook {

    private $file; 

    public function __construct(string $file)
    {
        $directory=dirname($file);
        if (!is_dir($directory)){
            mkdir($directory, 0777, true);
        }
        if (!file_exists($file)){
            touch($file);
        }
        $this->file = $file;
    }

    public function addMessage(Message $message): void
    {
            file_put_contents($this->file, $message->toJSON() . PHP_EOL , FILE_APPEND);
    }

    public function getMessages(): array
    {
        $messages = [];
        if (file_exists($this->file)) {
            $content = trim(file_get_contents($this->file));
            if (!empty($content)) {
                $lines = explode(PHP_EOL, $content);
                foreach ($lines as $line){
                    $data = json_decode($line, true);
                    $date = new DateTime();
                    $date->setTimeZone(new DateTimeZone('Europe/Paris'));
                    $messages[] = new Message($data['username'], $data['message'], $date);
                }
            }
        }
        return array_reverse($messages);
    }
 
}
?>