<?php

namespace App\Actions\Articles;

use App\Models\Article;
use App\Models\User;

class DeleteArticle
{
    public function handle(User $user, Article $article)
    {
        $article->delete();
    }
}
