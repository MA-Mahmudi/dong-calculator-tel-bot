<?php

require __DIR__ . '/../vendor/autoload.php';

//require "./src/calculate-dong.php";

use SergiX44\Nutgram\Nutgram;

$env = parse_ini_file('.env');
$botApiKey = $env["API_TOKEN"];

try {
    $bot = new Nutgram($botApiKey);

    $bot->onCommand('start', function (Nutgram $bot) {
        $message = "فرمت پیام به صورت:" . PHP_EOL . "نام: مبلغ" . PHP_EOL . "نام: مبلغ" . PHP_EOL . "نام: مبلغ";
        $bot->sendMessage($message);
    });

    $bot->onMessage(function (Nutgram $bot) {
        $bot->message();
        $bot->sendMessage("asdfasdfasfas");

    });
    $bot->run();

} catch (\Psr\Container\NotFoundExceptionInterface|\Psr\Container\ContainerExceptionInterface $e) {
}
