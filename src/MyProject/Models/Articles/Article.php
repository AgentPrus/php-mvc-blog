<?php

namespace MyProject\Models\Articles;

use MyProject\Models\Users\User;

class Article
{
    private $title;
    private $body;
    private $author;

    public function __construct(string $title, string $body, User $author)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }
}