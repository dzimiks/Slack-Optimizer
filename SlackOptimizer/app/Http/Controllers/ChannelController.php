<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlackRequest;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Helper;
use App\Channel;
use Auth;
use DB;

class ChannelController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('token');
    }

    /**
     * Get channel history and redirect to home.
     *
     * @param string $chat
     * @return Response
     */
    public function chat($chat)
    {
        $page = 1;
        $option='channels';
        // Initialize Slack request
        $request = new SlackRequest([
            'channel' => $chat,
            'count' => 50
        ]);

        // Get json from Slack
        $json = $request->getJSON('channels.history');

        $history = collect(Helper::prepareImsHistory($json));
        session(['sessionHistory' => $history]);

        $history=$history->slice(0,10);
        $history = $history->reverse();
        $chatName = Channel::where('chat_id', $chat)
                            ->where('user_id', Auth::user()->id)
                            ->first();

        $chatName = '#' . $chatName->name;

        return view('home', compact('history', 'chatName', 'chat', 'page', 'option'));
    }

    /**
     * Paginate channel history.
     *
     * @param $chat
     * @param int $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pagination($chat, $page=1)
    {
        $option = 'channels';
        $chatName = Channel::where('chat_id', $chat)
            ->where('user_id', Auth::user()->id)
            ->first();

        $chatName = '#' . $chatName->name;
        $startAt = ($page - 1) * 10;
        $history=session('sessionHistory');
        $history=$history->slice($startAt,10);
        $history = $history->reverse();

        return view('home', compact('history', 'chatName', 'chat', 'page', 'option'));
    }

    /**
     * Get channels from Slack for logged user
     * and store them to database.
     *
     * @return object
     */
    public function get()
    {
        // Initialize Slack request
        $request = new SlackRequest([
            'exclude_archived' => 1
        ]);

        // Get json from Slack
        $json = $request->getJSON('channels.list');

        Repository::saveChannels($json);
    }
}
