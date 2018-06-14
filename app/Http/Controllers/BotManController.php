<?php

namespace App\Http\Controllers;

use App\Reply;
use DOMDocument;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }

    public function getStart(BotMan $bot)
    {
        $replies = Reply::where('command', 'start')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
        $this->respond($bot, $replies);      
    }

    public function respond($bot, $replies)
    {
        if($replies->isEmpty()) {
            $bot->reply('I currently do not have any information to provide for that command.');
        } else {
            foreach($replies as $reply) {
                $bot->reply($reply->content, [
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true
                ]);
            } 
        } 
    }

    public function tinker()
    {
        return view('tinker');
    }
}
