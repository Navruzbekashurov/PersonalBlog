@extends('layouts.backend')

@section('title', 'Maqolalar ro‘yxati')

@section('content')
    <div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Maqolalar ro‘yxati</h3>
            <div class="block-options">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i> Yangi maqola
                </a>
            </div>
        </div>
        <div class="block-content">
            @if($articles->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>Sarlavha</th>
                            <th>Sana</th>
                            <th class="text-center" style="width: 150px;">Amallar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->published_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-alt-info">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-alt-danger" onclick="return confirm('O‘chirishga ishonchingiz komilmi?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $articles->links() }}
                </div>
            @else
                <p class="text-muted">Hozircha hech qanday maqola mavjud emas.</p>
            @endif
        </div>
    </div>
    </div>
@endsection
