<?php

use Facebook\Facebook;
use Service\ConfigProvider;
use Message\AnswerMessage;
use Message\QuestionProvider;

include (__DIR__ . '/vendor/autoload.php');

$configProvider = new ConfigProvider(__DIR__ . '/config.json');


//temporary guzzle client

// use GuzzleHttp\Client;

// $client = new Client([
//     'defaults' => [
//         'verify' => false,
//     ],
// ]);

// $request = $client->createRequest('GET', 'https://opentdb.com/api.php?difficulty=easy&amount=1');

// $response = $client->send($request);
// echo $response->getBody();

//end of temporary guzzle client


// $access_token = 'EAACj3xyZA820BALKZBwAIjlle70hGz16Nl84sc5M4783G3oxHsJz64OCFdlHMVpJVwRcr4KEXxAcFLXOZBy59EPKUdwmsLZAh46jOVCE6ZAhUQHBSzU0hkgC8RQb6OPlysxDPpJBFPfDZARSdwnpGxLngIjS2zlZBvWQ89BLx4YRgZDZD';
// $verify_token = 'TOKEN';
// $appId = '180178652885869';
// $appSecret = '6babfc63f0b1c956eda157371377b258';

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    if ($_REQUEST['hub_verify_token'] === $configProvider->getParameter('verify_token')) {
        echo $challenge; die();
    }
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
    exit;
}


$message = $input['entry'][0]['messaging'][0]['message']['text'];
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];

$fb = new Facebook([
    'app_id' => $configProvider->getParameter('app_id'),
    'app_secret' => $configProvider->getParameter('app_secret'),
]);

//give data1 answer to a message given by sender

if (strtolower($message) === 'quiz')
{
     
    $url = 'https://opentdb.com/api.php?difficulty=easy&amount=1';
    $answerMessage = new QuestionProvider();
    $answerMessage->setMessage($sender, $url);
    $data1 = $answerMessage->getMessage();
}
else
{
    $answerMessage = new AnswerMessage();           //create object
    $answerMessage->setMessage($sender, $message);  //set message
    $data1 = $answerMessage->getMessage();          //get message
}



//send response
$response = $fb->post('/me/messages', $data1, $configProvider->getParameter('access_token'));
