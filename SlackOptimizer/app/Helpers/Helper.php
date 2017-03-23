<?php

namespace App\Helpers;

use Auth;
use DB;

/**
 * Abstract Helper class stores helper functions.
 *
 * @author Milos Milosevic <milos.milosevic@labs.devana.rs>
 */
abstract class Helper
{
    /**
     * Prepare ims message history.
     *
     * @param array $ims
     * @return array $ims
     */
    public static function prepareImsHistory($ims)
    {
        $users = DB::table('ims')
                        ->where('user_id', Auth::user()->id)
                        ->pluck('username', 'slack_user_id')
                        ->toArray();

        $history = [];
        foreach($ims['messages'] as $message)
        {
            $history[] = [
                'username' => (isset($message['user'])) ? $users[$message['user']] : "Bot",
                'timestamp' => date('d-m-Y H:i', $message['ts']),
                'text' => Helper::parseText($message['text'], $users)
            ];
        }

        return $history;
    }

    /**
     * Parse chat id
     *
     * @param array $ims
     * @param string $userId
     * @return string $chatId
     */
    public static function parseChatId($ims, $userId)
    {
        foreach($ims as $im)
        {
            if($im['user'] == $userId)
                return $im['id'];
        }

        return null;
    }

    /**
     * Prepare text for displaying to user.
     *
     * @param string $text
     * @param array $users
     * @return string $text
     */
    private static function parseText($text, $users)
    {
        if($text == "") return "Unrecognized message";

        // Replace username
        preg_match_all('(<.*?>)', $text, $matches);

        foreach($matches[0] as $match)
        {
            $insert = $match;
            $exploded = explode('|', $match);
            if($exploded[0][1] == 'h')
            {
                $newString = Helper::escapeChars($exploded[0]);
                $insert = '<a target="_blank" class="messageLink" href="' . substr($newString, 1) . '">' . substr
                    ($newString,
                        1) . '</a>';
            }
            else if($exploded[0][1] == '@')
            {
                $newString = Helper::escapeChars($exploded[0]);
                $userId = substr($newString, 2);
                $userName = $users[$userId];
                $insert = '<span class="messageUsername">@' . $userName . '</span>';
            }

            $text = str_replace($match, $insert, $text);
        }

        return $text;
    }

    /**
     * Escape closing char.
     *
     * @param $text
     * @return string
     */
    private static function escapeChars($text)
    {
        if(substr($text, -1) == '>')
            return substr($text, 0, -1);

        return $text;
    }
}