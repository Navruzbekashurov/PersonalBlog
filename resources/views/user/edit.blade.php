@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Maqolani tahrirlash</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Sarlavha</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}">
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($article->image_path)
                        <div class="mb-3">
                            <label class="form-label">Joriy rasm</label><br>
                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="Article Image" style="max-width: 200px;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Yangi rasm yuklash</label>
                        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.svg">
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kontent</label>
                        <textarea name="content" class="form-control" rows="5">{{ old('content', $article->content) }}</textarea>
                        @error('content')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E'lon qilingan vaqti</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="{{ old('published_at', \Carbon\Carbon::parse($article->published_at)->format('Y-m-d\TH:i')) }}">
                        @error('published_at')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teglar</label>
                        <input type="text" name="tags" class="form-control"
                               placeholder="Teglarni vergul bilan ajratib yozing: sport, texnologiya, islam"
                               value="{{ old('tags', isset($article) ? $article->tags->pluck('name')->implode(', ') : '') }}">
                        <small class="text-muted">Bir nechta teglar uchun vergul qo‘ying.</small>
                        @error('tags')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Yangilash</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Bekor qilish</a>
                </form>
            </div>
        </div>
    </div>
@endsection
