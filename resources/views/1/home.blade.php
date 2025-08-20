@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">📰 Eng so‘nggi maqolalar</h3>
            </div>

            <div class="block-content">
                @forelse ($articles as $article)
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">
                                    <a href="{{ route('articles.show', $article->id) }}" class="text-dark">
                                        {{ $article->title }}
                                    </a>
                                </h4>
                                <div class="text-muted mb-2">
                                    <small><i class="fa fa-calendar me-1"></i> {{ $article->published_at->format('Y-m-d') }}</small>
                                </div>
                                <p class="mb-2 text-muted">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                            </div>
                            <div>
                                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-alt-primary">
                                    Batafsil <i class="fa fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Hozircha maqolalar mavjud emas.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
