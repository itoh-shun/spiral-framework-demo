@extends('template.base')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            記事の更新
        </div>
        @if($message)
            <div class="alert {{ ($isError) ? 'alert-danger' : 'alert-success' }}">
                {{ $message }}
            </div>
        @endif
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" value="{{ $validate['title']['value'] ?? $article->title }}" name="title" id="title" class="form-control {{ $validate['title']['isValid'] === false ? 'is-invalid' : '' }}">
                    <div class="invalid-feedback">
                        {{ $validate['title']['message'] ?? '' }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="content">内容</label>
                    <textarea name="content" id="content" rows="10" class="form-control {{ $validate['content']['isValid'] === false ? 'is-invalid' : '' }}">{{ $validate['content']['value'] ?? $article->content }}</textarea>
                    <div class="invalid-feedback">
                        {{ $validate['content']['message'] ?? '' }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">更新</button>
                <input type="hidden" value="{{ csrf_token() }}" name="_csrf">
                <input type="hidden" value="post" name="_method">
                <input type="hidden" value="{{ route('articles.update' , ['id' => $article->sysId ]) }}" name="_path">
            </form>
        </div>
    </div>
</div>
@endsection