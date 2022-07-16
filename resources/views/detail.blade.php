@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card border">

                <div class="card-header">

                    @if(!$user->photo)
                        <img class="avatar" alt="avatar" src="https://raw.githubusercontent.com/HouBenali/Assets/main/avatar.png"/>
                    @else
                        <img class="avatar" alt="avatar" src="{{ $user->photo }}"/>
                    @endif

                    @if( $user->id == $info->user_id)
                        <span>
                            {{ $user->name. ' '. $user->surname .' | '. '@'.$user->nick }}
                        </span>
                    @endif
                </div>
                <img class="photo" src="{{ $info->photo }}"></img>
                <div class="card-footer">

                        @if ($liked)
                        <a href="{{ route('dislike', $image_id) }}" class="button">
                           <img class="like" src="https://raw.githubusercontent.com/HouBenali/Assets/main/liked.png"  />
                        </a>

                        @else

                        <a href="{{ route('like', $image_id) }}" class="button">
                            <img class="like" src="https://raw.githubusercontent.com/HouBenali/Assets/main/like.png"  />
                        </a>
                        @endif
                        <span class="likeCount">{{$countLikes}}</span>
                        @if( $user->id == $info->user_id)

                        <span class="nickname likeCount">{{ ' | @'.$user->nick .'| '.\FormatTime::LongTimeFilter($info->created_at) .' | '.  $info->description }}</span>

                        @endif
                        <br>
                </div>

                <div class="card"><br>
                    <p></p>
                    @if (session('commented'))
                        <h4 class="message">Commented successfully</h4>
                    @endif
                    @if (session('deleted'))
                        <h4 class="message">Comment deleted successfully</h4>
                    @endif

                <form method="POST" action="{{ route('comment', $image_id) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description">
                    </textarea>
                    <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                    </form>


                    @if(!empty($comments) && $comments->count())
                        @foreach($comments->reverse() as $key => $comment)
                            @if($image_id == $comment->image_id)
                            <hr>
                            <div class="comments">
                                <span>
                                {{ '@'.$users->find($comment->user_id)->nick. ' | '.\FormatTime::LongTimeFilter($comment->created_at) .' | '. $comment->content .' '}}
                                </span>
                                @if($logged_user == $comment->user_id || $logged_user==$user->id)
                                <a onclick="return confirm('Are you sure?')" href="{{ route('delete', ['id' => $comment->id]) }}"><img height="12" width="12" src="{{ asset('users/delete.png')}}"></a>
                                @endif
                            </div>
                            @endif

                        @endforeach
                        <hr>
                    @endif

                    </div>
                    </div>


</div>

</body>
</html>
@endsection
