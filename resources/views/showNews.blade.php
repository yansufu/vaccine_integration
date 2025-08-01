@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h1>{{ $news->title }}</h1>
    <p><small>Diperbarui {{ $news->updated_at->diffForHumans() }}</small></p>
    <img src="{{ asset('storage/news_images/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid mb-3" style="max-height: 400px; object-fit: cover;">
    <div>
        {!! nl2br(e($news->content)) !!}
    </div>
    <a href="{{ route('new') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Berita</a>
</div>

@endsection
