<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;


class ArticlesController extends AbstractController
{
    public function view(int $article_id)
    {
        $article = Article::getById($article_id);

        if (empty($article)) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);

    }

    public function edit(int $article_id): void

    {
        $article = Article::getById($article_id);

        if (empty($article)) {
            $this->view->renderHtml('errors/404.php', [], 'Page Not Found', 404);
            return;
        }

        $article->setName('New Article Name');
        $article->setText('New Article Text');

        $article->save();
    }

    public function create(): void
    {
        $author = User::getById(1);
        $article = new Article();

        $article->setAuthor($author);
        $article->setName('This is new Article Name');
        $article->setText('This is New Article Text');

        $article->save();

    }

    public function delete(int $article_id): void
    {
        $article = Article::getById($article_id);

        if (empty($article)) {
            $this->view->renderHtml('errors/404.php', [], 'Page Not Found', 404);
            return;
        }

        $article->delete();

        $this->view->renderHtml('articles/delete.php', ['article' => $article], 'Deleted Article');
    }
}