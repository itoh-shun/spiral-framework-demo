@extends('template.base')

@section('content')
<div class="container">
    <h1>記事一覧</h1>
    @if($message)
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    <form method="post" action="{{ config('url.root') }}">
        <input type="hidden" value="get" name="_method">
        <input type="hidden" value="{{ route('articles.create') }}" name="_path">
        <button type="submit" class="btn btn-primary">新規登録</button>
    </form>
    {!! $limits !!}
    <table class="table">
        <thead>
            <tr>
                <th>更新</th>
                <th>作成日</th>
                <th>タイトル</th>
                <th>内容</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td>
                    <a href="#" onclick="update({{ $article->sysId }})">更新</a>
                </td>
                <td>{{ $article->created_at }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->content }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $pagination !!}

    <form method="post" action="{{ config('url.root') }}" id="updateform">
        <input type="hidden" value="get" name="_method">
        <input type="hidden" value="" name="_path">
    </form>

    <script>
        function update(id){
            //ここで_pathのValueを書き換えたい
            console.log(document.getElementById("updateform").querySelector('input[name="_path"]'));
            document.getElementById("updateform").querySelector('input[name="_path"]').value = "article/" + id;
            document.getElementById("updateform").submit();
        }
    </script>
</div>
@endsection