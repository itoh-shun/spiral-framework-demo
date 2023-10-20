@extends('template.base')

@section('content')
<div class="container">
    <h1>記事一覧</h1>
    @if($message)
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    <form method="post" action>
        <input type="hidden" value="{{ route('articles.create') }}" name="_path">
        <button type="submit" class="btn btn-primary">新規登録</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>作成日</th>
                <th>タイトル</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td>{{ $article->created_at }}</td>
                <td>{{ $article->title }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection