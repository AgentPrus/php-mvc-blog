<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentsException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;

class ArticlesController extends AbstractController
{
    public function view(int $article_id)
    {
        $article = Article::getById($article_id);

        if (empty($article)) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php',
            [
                'article' => $article,
                'user' => $this->user
            ]);

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
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('articles/create.php', ['error' => $e->getMessage()], 'Create Article');
                return;
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articles/create.php', [], 'Create Article');
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