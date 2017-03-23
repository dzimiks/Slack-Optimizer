@extends('layouts.app')
@section('inner')
    <div class="selectContainer">
        <div class="selectWrapper">
            <h1>Channels</h1>
            <div class="part">Recent Conversations</div>
            @foreach($channels as $channel )
                <a class="links" href="/channels/chat/{{$channel->chat_id}}">
                    <div class="choiceWrapper">
                        <span class="choiceName">#{{$channel->name}} </span>
                    </div>
                </a>
            @endforeach
            <br/>
            <div class="part">Other Conversations</div>
            @foreach($otherChannels as $channel )
                <a class="links" href="/channels/chat/{{$channel->chat_id}}">
                    <div class="choiceWrapper">
                        <span class="choiceName">#{{$channel->name}} </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection