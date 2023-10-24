<?php
namespace App\Model;

use framework\SpiralConnecter\SpiralModel;

class Article extends SpiralModel {

    // テーブル名と主キーの設定
    protected array $fields= ['id','sysId','created_at','updated_at' , 'title', 'content'];
    protected string $db_title = 'articles';
    protected string $primaryKey = 'sysId';

    public function pagination($page = 1 , $limit = 10) {
        /** @phpstan-ignore-next-line */
        $instance = new static();
        return $instance->getManager()->page($page)->paginate($limit);
    }
}