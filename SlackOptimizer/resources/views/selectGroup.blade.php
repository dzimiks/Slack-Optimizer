@extends('layouts.app')
@section('inner')
    <div class="selectContainer">
        <div class="selectWrapper">
            <h1>Groups</h1>
            <div class="part">Recent Conversations</div>
            @foreach($groups as $group)
                <a class="links" href="/groups/chat/{{$group->chat_id}}">
                    <div class="choiceWrapper">
                        <span class="choiceName">#{{$group->name}} </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection