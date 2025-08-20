@extends('layouts.backend')

@section('styles')
    <style>
        .article-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .article-tags .badge {
            font-size: 0.75rem;
            margin: 0 2px 4px 0;
            padding: 0.4em 0.6em;
            border-radius: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        {{-- Bo‘lim sarlavhasi --}}
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5">📄 O‘zimning maqolalarim</h1>
            <p class="text-muted fs-5">Bu yerda siz yozgan barcha maqolalar ro‘yxati chiqadi</p>
            <a href="{{ route('myarticle') }}" class="btn btn-lg btn-outline-primary mt-2">
                Mening maqolalar sahifam
            </a>
        </div>
        @if($allTags->count())
            <div class="mb-4 text-center">
                <a href="{{ route('articles.index') }}" class="badge {{ empty($selectedTag) ? 'bg-primary' : 'bg-secondary' }}">
                    Barchasi
                </a>
                @foreach($allTags as $tag)
                    <a href="{{ route('articles.byTag', $tag->id) }}"
                       class="badge {{ isset($selectedTag) && $selectedTag->id == $tag->id ? 'bg-primary' : 'bg-secondary' }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="row items-push">
            @foreach($articles as $article)
                <div class="col-md-6 col-xl-4">
                    <div class="block block-rounded h-100 mb-0 shadow-sm">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ $article->title }}</h3>
                        </div>
                        <div class="block-content text-muted fs-sm">
                            @if ($article->image_path)
                                <img src="{{ asset('storage/' . $article->image_path) }}"
                                     class="img-fluid rounded mb-3 article-image"
                                     alt="{{ $article->title }}">
                            @endif

                            {{-- Taglar --}}
                            @if($article->tags->count())
                                <div class="article-tags mb-3">
                                    @foreach($article->tags as $tag)
                                        <span class="badge bg-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <p>{{ Str::limit($article->content, 100) }}</p>
                            <small class="text-muted">
                                {{ $article->published_at?->format('Y-m-d') }}
                            </small>
                        </div>
                        <div class="block-content border-top text-center">
                            <a href="{{ route('articles.show', $article->id) }}"
                               class="btn btn-sm btn-primary">Batafsil</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
