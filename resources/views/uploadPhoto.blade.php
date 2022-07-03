@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ asset('css/uploadPost.css') }}" >

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">{{ __('Upload Photo') }}</div>

                <div class="card-body">
                    @if (session('posted'))
                        <h4 class="message">Photo uploaded successfully</h4>
                    @endif

                    <div class="card-body">
                        @if (session('notposted'))
                            <h4 class="ErrorMessage"></h4>
                        @endif

                    <form method="POST" action="{{ route('postPhoto') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required autocomplete="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description">
                                </textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                    </form>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>
@endsection
