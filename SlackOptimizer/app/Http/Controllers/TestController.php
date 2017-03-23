<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlackRequest;
use App\Im;

class TestController extends Controller
{
    public function index()
    {
        // Initialize Slack request
        $slackRequest = new SlackRequest([
            'user' => 'U0FBXG4LD'
        ]);

        // Get json from Slack
        $success = $slackRequest->getJSON('im.open');
        $user = Im::where('slack_user_id', 'U0FBXG4LD')->update(['chat_id' => $success['channel']['id']]);

        $find = Im::where('slack_user_id', 'U0FBXG4LD')->first();

        return redirect('ims/chat/' . $success['channel']['id']);
    }
}
