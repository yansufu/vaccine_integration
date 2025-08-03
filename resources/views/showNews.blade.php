@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>{{ $news->title }}</h1>
    <p><small>Last updated {{ $news->updated_at->diffForHumans() }}</small></p>

    @if ($news->image)
        <img src="{{ asset('storage/news_images/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid mb-3" style="max-height: 400px; object-fit: cover;">
    @endif

    <div>
        {!! nl2br(e($news->content)) !!}
    </div>

    <a href="{{ route('news.index') }}" class="btn btn-secondary mt-3">Back to News List</a>
</div>
@endsection
