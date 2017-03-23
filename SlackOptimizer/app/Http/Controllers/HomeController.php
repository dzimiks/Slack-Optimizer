<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests\SlackRequest;

class HomeController extends Controller
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
     * Main homepage.
     *
     * @return view
     */
    public function index()
    {
        $chat='';
        $page=1;
        $history = [];
        $chatName = null;
        $chatId = null;
        $option='';

        return view('home', compact('history', 'chatName', 'chatId', 'page', 'chat', 'option'));
    }

    /**
     * Send message.
     *
     * @param Request $request
     * @param  string $chat
     * @return response
     */
    public function send(Request $request, $chat)
    {
        // Initialize Slack request
        $request = new SlackRequest([
            'channel' => $chat,
            'text' => $request->message,
            'as_user' => true
        ]);

        // Get json from Slack
        $request->getJSON('chat.postMessage');

        return back();
    }

    /**
     * All channels.
     *
     * @return view
     */
    public function allChannels()
    {
        $channels = DB::table('channels')
            ->where('user_id', Auth::user()->id)
            ->where('is_member', true)
            ->get();

        $otherChannels = DB::table('channels')
            ->where('user_id', Auth::user()->id)
            ->where('is_member', false)
            ->get();

        return view('selectChannel',compact('channels','otherChannels'));
    }

    /**
 * All users.
 *
 * @return view
 */
    public function allUsers()
    {
        $ims = DB::table('ims')
            ->where('user_id', Auth::user()->id)
            ->where('chat_id', '!=', null)
            ->get();

        $otherIms = DB::table('ims')
            ->where('user_id', Auth::user()->id)
            ->where('chat_id', '=', null)
            ->get();

        return view('selectUser',compact('ims', 'otherIms'));
    }

    /**
     * All groups.
     *
     * @return view
     */
    public function allGroups()
    {
        $groups = DB::table('groups')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('selectGroup',compact('groups'));
    }
}
