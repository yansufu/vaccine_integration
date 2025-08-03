@extends('layouts.app')
@section('content')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            @if(count($news) >= 2)
                <div class="row">

                    <!-- Large Left Column -->
                    <div class="col-md-8">
                        <div class="card text-bg-dark">
                            <img src="{{ asset('storage/news_images/' . $news[0]->image) }}" class="card-img" alt="News Image">
                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                <a style="text-decoration: none" href="{{ route('news.show', $news[0]->id) }}">
                                    <h4 class="card-title text-light">{{ $news[0]->title }}</h4>
                                </a>
                                <p class="card-text">
                                    <small>Last updated {{ $news[0]->updated_at->diffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Small Right Column -->
                    <div class="col-md-4 mb-4">
                        <div class="card news-card h-100">
                            <img src="{{ asset('storage/news_images/' . $news[1]->image) }}" class="card-img-top" alt="News Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $news[1]->title }}</h5>
                                <p class="card-text">
                                    <small>Last updated {{ $news[1]->updated_at->diffForHumans() }}</small>
                                </p>
                                <a href="{{ route('news.show', $news[1]->id) }}" class="btn btn-outline-danger btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-5 mt-5" id="news" style="background-image: url('images/bg.png'); background-size: cover;">
        <div class="container">
            <div class="col-2 mb-4 mx-auto">
                <h3 class="text-center border border-danger fw-bold text-danger p-2" style="border-radius: 18px">Latest News</h3>
            </div>

            <div class="row">
                @foreach ($news as $new)
                    <div class="col-md-4 mb-4">
                        <div class="card news-card h-100">
                            <img src="{{ asset('storage/news_images/' . $new->image) }}" class="card-img-top" alt="News Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $new->title }}</h5>
                                <a href="{{ route('news.show', $new->id) }}" class="btn btn-outline-danger btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

@endsection
