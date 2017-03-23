@extends('layouts.app')

@section('inner')
    <div class="sideBarIcon" onclick="showSideBar()"><hr/><hr/><hr/>
    </div>
    <div class="sideBar">
        <div class="info">
            <a href="/" class="links">
                <span class="teamName">{{Auth::user()->team_name}}</span><br/>
                <span class="mainUser">{{Auth::user()->name}}</span>
            </a>
        </div>

        <div class="section"><a href="/channels" class="links">CHANNELS <span class="plus">+</span></a></div>
        <div class="section"><a href="/groups" class="links">GROUPS<span class="plus">+</span></a></div>
        <div class="section"><a href="/ims" class="links">DIRECT MESSAGES <span class="plus">+</span></a></div>
        <a href="{{ url('/logout') }}" class="logout links"
           onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
    </div>
    <div class="content" >
        @if(empty($history) && count($errors)===0)
            <div class="welcome">
                <div class="firstLine">Welcome to Optimizer</div>
                <div class="secondLine">New way to use Slack on slow connections</div>
            </div>
        @elseif (count($errors) > 0)
            <div class="welcome">

                @foreach ($errors->all() as $error)
                    <div class="firstLine error">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="sideBarMask" onclick="hideSideBar()"></div>
        @if(!empty($history))
        <form method="post" action="{{url('/' . $chat)}}">
            {{csrf_field()}}

            <div class="userInfo">
                <span id="labelSendTo">{{$chatName}}</span>
                @if(isset($fullName))
                    <p class="fullName">{{$fullName}}</p>
                @endif

            </div>

            <div class="historyMessages">
                @if($page!=5 && count($history)>=10)
                    <div class="otherMessages"><a class="links" href="/{{$option}}/chat/{{$chat}}/{{$page+1}}">Show older messages</a></div>
                @endif

                @foreach($history as $message)
                    <div class="userName">&#64{{$message['username']}}</div>
                    <div class="messageTime">{{$message['timestamp']}}</div>
                    <p class="message">{!!$message['text']!!}</p>
                @endforeach
                @if($page>1)
                    <div class="otherMessages"><a class="links" href="/{{$option}}/chat/{{$chat}}/{{$page-1}}">Show newest messages</a></div>
                @endif
                <script>
                    var historyMessages = document.getElementsByClassName("historyMessages")[0];
                    historyMessages.scrollTop=historyMessages.scrollHeight;
                </script>
            </div>

            <div class="sendWrapper">
                <textarea name="message" rows="1" class="newMessage"></textarea>
                <input type="submit" value="Send" class="sendMessage">
            </div>

        </form>
        @endif

    </div>

@endsection
