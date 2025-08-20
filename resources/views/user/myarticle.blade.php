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
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5">📄 O‘zimning maqolalarim</h1>
            <p class="text-muted fs-5">Bu yerda siz yozgan barcha maqolalar ro‘yxati chiqadi</p>
            <a href="{{ route('myarticle') }}" class="btn btn-lg btn-outline-primary mt-2">Mening maqolalar sahifam</a>
        </div>

        {{-- CREATE tugmasi --}}
        <div class="mb-4 text-end">
            <a href="{{ route('articles.create') }}" class="btn btn-success">
                ➕ Yangi maqola qo‘shish
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
            @foreach($articles as $articl)
                <div class="col-md-6 col-xl-4">
                    <div class="block block-rounded h-100 mb-0 shadow-sm">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ $articl->title }}</h3>
                        </div>
                        <div class="block-content text-muted fs-sm">
                            @if ($articl->image_path)
                                <img src="{{ asset('storage/' . $articl->image_path) }}" class="img-fluid rounded mb-3 article-image" alt="{{ $articl->title }}">
                            @endif

                            @if($articl->tags->count())
                                <div class="article-tags mb-3">
                                    @foreach($articl->tags as $tag)
                                        <a href="{{ route('articles.byTag', $tag->id) }}" class="badge bg-primary">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            @endif

                            <p>{{ Str::limit($articl->content, 100) }}</p>
                            <small class="text-muted">{{ $articl->published_at?->format('Y-m-d') }}</small>
                        </div>

                        {{-- CRUD tugmalari --}}
                        <div class="block-content border-top text-center">
                            <a href="{{ route('articles.show', $articl->id) }}" class="btn btn-sm btn-primary">👁 Batafsil</a>
                            <a href="{{ route('articles.edit', $articl->id) }}" class="btn btn-sm btn-warning">✏️ Tahrirlash</a>
                            <form action="{{ route('articles.destroy', $articl->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Haqiqatan ham ushbu maqolani o‘chirmoqchimisiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑 O‘chirish</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
