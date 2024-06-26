<?php

require __DIR__ . '/../vendor/autoload.php';

require "./src/calculate-dong.php";

use SergiX44\Nutgram\Nutgram;

$env = parse_ini_file('.env');
$botApiKey = $env["API_TOKEN"];

try {
    $bot = new Nutgram($botApiKey, ["timeout" => 60000]);

    $bot->onCommand('start', function (Nutgram $bot) {
        $message = "فرمت پیام به صورت:" . PHP_EOL . "نام:مبلغ" . PHP_EOL . "نام:مبلغ" . PHP_EOL . "نام:مبلغ";
        $bot->sendMessage($message);
    });

    $bot->onMessage(function (Nutgram $bot) {
        $message = $bot->message()->getText();
        $isValidFlag = true;
        foreach (explode("\n",$message) as $item){
            if(!preg_match("/^[@\x{0600}-\x{06FF}a-zA-Z\d]+:\d*$/u", $item)){
                $isValidFlag = false;
            }
        }
        if ($isValidFlag){
            $temp = explode("\n", $message);
            $res = [];
            $resMessage = "";
            foreach ($temp as $person) {
                $temp2 = explode(":", $person);
                $res[trim($temp2[0])] = trim($temp2[1]);
            }
            $dongs = calculateDong($res);
            foreach ($dongs as $key => $value) {
                if ($value != 0) {
                    $resMessage .= $key . ": " . $value . "\n";
                }
            }
            $bot->sendMessage($resMessage);
        }
    });

    $bot->run();

} catch (\Psr\Container\NotFoundExceptionInterface|\Psr\Container\ContainerExceptionInterface $e) {
}
