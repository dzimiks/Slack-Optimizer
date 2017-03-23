@extends('layouts.app')
@section('inner')
    <div class="selectContainer">
        <div class="selectWrapper">
            <h1>Direct Messages</h1>
            <div class="part">Recent Conversations</div>
            @foreach($ims as $im)
                <a class="links" href="/ims/chat/{{$im->chat_id}}">
                    <div class="choiceWrapper">
                        <span class="choiceName">&#64{{$im->username}} </span>
                        @if($im->name != '')
                            <span>| {{$im->name}}</span>
                        @endif
                    </div>
                </a>
            @endforeach
            <br/>
            <div class="part">Other Conversations</div>
            @foreach($otherIms as $im)
                <a class="links" href="/ims/new/{{$im->slack_user_id}}">
                    <div class="choiceWrapper">
                        <span class="choiceName">&#64{{$im->username}} </span>
                        @if($im->name != '')
                            <span>| {{$im->name}}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection