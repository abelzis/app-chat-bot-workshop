<?php

namespace Message;

use GuzzleHttp\Client;

class QuestionProvider
{
    //private $data;

    private $data;

    private function getBody($url)
    {
        $client = new Client([
            'defaults' => [
                'verify' => false,
            ],
        ]);
        
        $request = $client->createRequest('GET', $url);
        //$request = $client->createRequest('GET', 'https://opentdb.com/api.php?difficulty=easy&amount=1');
        
        $response = $client->send($request);
        //$response->getBody();

        return json_decode($response->getBody(), true);
    }

    //retuns answer
    public function setMessage($sender, $url)
    {
        $message = $this->getBody($url);


        $this->data = [
            'messaging_type' => 'RESPONSE',
            'recipient' => [
                'id' => $sender,
            ],
            'message' => [
                'text' => 'Question is: ' . $message['results'][0]['question'],
            ]
            
        ];
    }

    public function getMessage()
    {
        return $this->data;
    }


    // //get config
    // private function parseConfig()
    // {
    //     return json_decode(file_get_contents($this->configFile), true);
    // }

    // public function __construct($configFile)
    // {
    //     $this->configFile = $configFile;
    // }

    
    // public function getParameter($parameter)
    // {
    //     $config = $this->parseConfig();
    //     return $config[$parameter];
    // }
}

?>