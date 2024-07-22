<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class DeleteArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('delete', $this->article);
    }
}
