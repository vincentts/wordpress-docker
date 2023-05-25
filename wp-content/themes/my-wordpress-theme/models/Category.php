<?php

namespace Models;

use Vincentts\WpModels\TermModel;
use Models\Post;

class Category extends TermModel {
    protected $taxonomy = 'category';

    public function posts() {
        return $this->has( Post::class );
    }
}