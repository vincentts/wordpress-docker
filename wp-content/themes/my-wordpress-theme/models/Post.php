<?php

namespace Models;

use Vincentts\WpModels\PostModel;
use Models\Category;

class Post extends PostModel {
    
    protected $post_type = 'post';

    public function categories() {
        return $this->has( Category::class );
    }

}