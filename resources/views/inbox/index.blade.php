@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>

                    <div class="panel-body">
                        @foreach($messages as $key => $messageGroup)
                            <div class="media">
                                <div class="media-left">
                                    @if(user()->id == $key)
                                        <a href="">
                                            <img width="45px" src="{{$messageGroup->fromUser->avatar}}">
                                        </a>
                                    @else
                                        <a href="">
                                            <img width="45px" src="{{$messageGroup->toUser->avatar}}">
                                        </a>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        @if(user()->id == $key)
                                            <a href="">
                                                {{$messageGroup->fromUser->name}}
                                            </a>
                                        @else
                                            <a href="">
                                                {{$messageGroup->toUser->name}}
                                            </a>
                                        @endif
                                    </h4>
                                    <p><a href="/inbox/{{$messageGroup->dialog_id}}">
                                            {{$messageGroup->body}}
                                        </a></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
