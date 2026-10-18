<?php

class Category
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Получить только те категории, в которых есть статьи (для главной страницы)
    public function getAllWithArticles()
    {
        $sql = "SELECT DISTINCT c.*
                FROM categories c
                JOIN article_category ac ON ac.category_id = c.id
                ORDER BY c.name ASC";

        return $this->pdo->query($sql)->fetchAll();
    }

    // Получить одну категорию по ее ID (для страницы категории)
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Получить все категории одной статьи (для страницы статьи)
    public function getByArticleId($articleId)
    {
        $sql = "SELECT c.*
                FROM categories c
                JOIN article_category ac ON ac.category_id = c.id
                WHERE ac.article_id = ?
                ORDER BY c.name ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }
}