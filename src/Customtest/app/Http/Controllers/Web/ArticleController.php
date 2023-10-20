<?php

namespace Customtest\App\Http\Controllers\Web;

use App\Model\Article;
use framework\Http\Controller;
use framework\Routing\Router;
use SiValidator2\SiValidator2;

class ArticleController extends Controller
{
    public function index(array $vars)
    {
        $articles = (new Article)->pagination(1);
        echo view('html.articles.index', [
            'articles' => $articles->getData(),
            'message' => $this->request->session()->pull('message')
        ]);
    }

    public function create(array $vars)
    {
        $validator = $this->request->session()->pull('validate');
        echo view('html.articles.create', [
            'isError' => $this->request->session()->pull('isError'),
            'message' => $this->request->session()->pull('message'),
            'validate' => [
                'title' => $validator ? $validator['title']->toArray() : null,
                'content' => $validator ? $validator['content']->toArray(): null,
            ]
        ]);
    }

    public function store($vars)
    {
        $values = [
            'title' => $this->request->get('title'),
            'content' => $this->request->get('content'),
        ];

        $rules = [
            'title' => ['required','max_bytes:128'],
            'content' => ['required','max_bytes:8192']
        ];

        $labels = [
            'title' => 'タイトル',
            'content' => '内容'
        ];

        $validator = SiValidator2::make($values, $rules , $labels);
        
        if ($validator->isError()) {
            $this->request->setMethod('get');
            $this->request->session()->put('isError', true);
            $this->request->session()->put('message', 'エラーが発生しました');
            $this->request->session()->put('validate', $validator->getResults());
            Router::redirect(route('articles.create', $vars) , $this->request);
        } else {
            $article = new Article;
            $article->title = $this->request->get('title');
            $article->content = $this->request->get('content');
            $article->save();

            $this->request->setMethod('get');
            $this->request->session()->put('isError', false);
            $this->request->session()->put('message', '登録が完了しました');
            Router::redirect(route('articles.index', $vars) , $this->request);
        }
        exit;
    }
}
