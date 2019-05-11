<?php

namespace Message;

class AnswerMessage
{
    private $data;


    public function __construct()
    {

    }

    public function setMessage($sender, $message)
    {
        if ($message == 'Antanas')
    $this->data = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => 'Hello, ' . $message,
        ]
        ];

else if ($message == 'date')
    $this->data = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => 'Today is ' . date("Y/m/d"),
        ]
        ];

else if ($message == 'time')
    $this->data = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => 'The time is ' . date("H:i:s"),
        ]
        ];

else
    $this->data = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => 'You wrote: ' . $message,
        ]
        
    ];
    }

    public function getMessage()
    {
        return $this->data;
    }
}

?>