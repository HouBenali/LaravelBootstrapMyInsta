@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
</head>
<body>
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card border">


        @if(!empty($data) && $data->count())
                @foreach($data as $key => $value)
             
                <a class="detall" href="{{ route('detail',$value->id)}}">
                <div class="card-header"> 

                    @if(!$users->find($value->user_id)->image)
                        <img  class="avatar" alt="avatar" src="{{ asset('users/null.jpg') }}"/>
                    @else
                        <img  class="avatar" alt="avatar" src="{{ asset('users/'.($users->find($value->user_id)->image)) }}"/>
                    @endif
                            @if( $users->find($value->user_id)->id==$value->user_id)
                                <span>
                                    {{ $users->find($value->user_id)->name . ' '. 
                                        $users->find($value->user_id)->surname .' | '.
                                         '@'.$users->find($value->user_id)->nick }}
                                </span>
                            @endif
                </div>

                    <img class="photo" src="{{ asset('images/'.$value->image_path) }}"></img>
                    <div class="card-footer">

                
                    @if( $users->pluck('id')->contains($value->user_id))
                        @if (\Liked::IsLiked($value->id))
                            <a href="{{ route('dislike', $value->id) }}" class="button">
                            <img class="like" src="{{ asset('users/liked.png') }}"  />
                            </a> 

                            @else      

                            <a href="{{ route('like', $value->id) }}" class="button">
                                <img class="like" src="{{ asset('users/like.png') }}"  />
                            </a>
                            @endif
                            <span class="likeCount">{{\CountLikes::LikesCounter($value->id)}}</span>

                        <span class="nickname date">{{ '@'.$users->pluck('nick')[$value->user_id-1]}}</span>
                        <span class="nickname date">
                            {{ ' | '.\FormatTime::LongTimeFilter($value->created_at) }}
                        </span>

                    @endif
                    <br>
                        {{$value->description}} 
                    </div>
                </a>
                <div style=" background-color: #f8f9fa; color: #f8f9fa;">.</div>
                @endforeach
        @endif
        
    {!! $data->links() !!}
</div>
     
</body>
</html>
@endsection
