<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');
// Default Commands
$botman->hears('/start', BotManController::class.'@getStart');
//
$botman->hears('/help', BotManController::class.'@getStart');
// Custom Commands

// Fallback
$botman->fallback(function($bot) {
	$payload = $bot->getMessage()->getPayload();
	
	if(isset($payload['text'])) {
		$message = $payload['text'];
		
		if(substr($message, 0, 1) == '/') {
			$bot->reply('That is not a command I recognize. Type /help to see a full list.');
		}
	}
});
