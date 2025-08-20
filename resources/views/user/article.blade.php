@extends('layouts.backend')

@section('content')
    <div class="content content-full">

        {{-- Maqola bloki --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title mb-0">{{ $article->title }}</h3>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary">
                        {{ $article->published_at->format('Y-m-d') }}
                    </span>
                </div>


                <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                        <span class="text-muted">
            Muallif: {{ $article->user->name ?? 'Noma’lum' }}
        </span>
                    </div>
                </div>



            </div>

            <div class="block-content fs-md lh-base">
                <p>{!! nl2br(e($article->content)) !!}</p>
            </div>

            <div class="block-content border-top d-flex justify-content-end text-muted">
                <small><i class="fa fa-eye me-1"></i> {{ $article->views }} marta ko‘rilgan</small>
            </div>
            <div class="block-content">
                @if ($article->image_path)
                    <img src="{{ asset('storage/' . $article->image_path) }}" class="img-fluid rounded mb-3" alt="{{ $article->title }}">
                @endif
                <p>{!! nl2br(e($article->content)) !!}</p>
            </div>

        </div>
    {{-- Teglar --}}
    @if($article->tags->count() > 0)
        <div class="block-content border-top pt-3">
            <h5 class="mb-2">Teglar:</h5>
            @foreach($article->tags as $tag)
                <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
            @endforeach
        </div>
    @endif


    {{-- Izohlar ro'yxati --}}
        <div class="block block-rounded mt-4 m-3">
            <div class="block-header block-header-default">
                <h3 class="block-title mb-0">Izohlar</h3>
            </div>
            <div class="block-content">
                @forelse ($article->comments as $comment)
                    <div class="mb-3 pb-3 border-bottom">
                        <strong class="d-block">{{ $comment->user->name ?? 'Anonim' }}</strong>
                        <p class="mb-0">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-muted">Hozircha izohlar yo'q.</p>
                @endforelse
            </div>
        </div>

        {{-- Izoh qoldirish formasi --}}
        <div class="block block-rounded mt-4 m-3">
            <div class="block-header block-header-default">
                <h3 class="block-title mb-0">Izoh qoldiring</h3>
            </div>
            <div class="block-content">
                {{-- Xatoliklar --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Forma --}}
                <form action="{{ route('articles.comments.store', $article->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="content" class="form-label">Izoh</label>
                        <textarea name="content" id="content" rows="4" class="form-control" required>{{ old('content') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane me-1"></i> Yuborish
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
