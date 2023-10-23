<?php

namespace Customtest\App\Http\Controllers\Web;

use App\Model\Article;
use Csrf;
use Exception;
use framework\Http\Controller;
use framework\Routing\Router;
use framework\SpiralConnecter\RateLimiter;
use SiValidator2\SiValidator2;

class ArticleController extends Controller
{
    public function index(array $vars)
    {
        $limit = (int)$this->request->get('limit', 10);
        $page = (int)$this->request->get('page', 1);
        $articles = (new Article)->pagination($page , $limit);
        echo view('html.articles.index', [
            'limits' => $articles->limits(),
            'articles' => $articles->getData(),
            'pagination' => $articles->links(),
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
        //CSRFが一致しなければリダイレクト
        if(Csrf::validate($this->request->get('_csrf')) === false){
            Router::redirect(route('articles.index', $vars) , $this->request);
            exit;
        }

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

            Csrf::regenerate(); // リロード対策

            Router::redirect(route('articles.index', $vars) , $this->request);
        }
        exit;
    }

    
    public function edit(array $vars)
    {
        $article = Article::find($vars['id']);

        if(empty($article)){
            throw new Exception('Not Found.', 404);
        }


        $validator = $this->request->session()->pull('validate');

        echo view('html.articles.edit', [
            'isError' => $this->request->session()->pull('isError'),
            'message' => $this->request->session()->pull('message'),
            'validate' => [
                'title' => $validator ? $validator['title']->toArray() : null,
                'content' => $validator ? $validator['content']->toArray(): null,
            ],
            'article' => $article            
        ]);
    }

    
    public function update($vars)
    {
        $old_article = Article::find($vars['id']);
        if(empty($old_article)){
            throw new Exception('Not Found.', 404);
        }

        //CSRFが一致しなければリダイレクト
        if(Csrf::validate($this->request->get('_csrf')) === false){
            Router::redirect(route('articles.edit', $vars) , $this->request);
            exit;
        }

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
            Router::redirect(route('articles.edit', $vars) , $this->request);
        } else {
            $article = new Article;
            $article->sysId = $old_article->sysId;
            $article->title = $this->request->get('title');
            $article->content = $this->request->get('content');
            $article->save();

            $this->request->setMethod('get');
            $this->request->session()->put('isError', false);
            $this->request->session()->put('message', '更新が完了しました');

            Csrf::regenerate(); // リロード対策

            Router::redirect(route('articles.index', $vars) , $this->request);
        }
        exit;
    }

}
