<?php

class Article
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Общее количество статей
    public function countAll()
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    }

    // Получить одну статью по ID
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Увеличить счётчик просмотров на 1
    public function increaseViews($id)
    {
        $stmt = $this->pdo->prepare("UPDATE articles SET views = views + 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Получить 3 последних статьи для конкретной категории, для главной страницы
    public function getLatestByCategory($categoryId, $limit = 3)
    {
        $sql = "SELECT a.* FROM articles a
                JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = :cat_id
                ORDER BY a.created_at DESC, a.id DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Получить статьи категории с сортировкой и пагинацией
    public function getByCategory($categoryId, $sort = 'date', $page = 1, $limit = 6)
    {
        $offset = ($page - 1) * $limit;

        // Название колонки выбираем из двух вариантов
        if ($sort === 'views') {
            $orderBy = 'a.views DESC, a.id DESC';
        } else {
            $orderBy = 'a.created_at DESC, a.id DESC';
        }

        $sql = "SELECT a.* FROM articles a
                JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = :cat_id
                ORDER BY $orderBy
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Посчитать общее количество статей в категории
    public function getTotalByCategory($categoryId)
    {
        $sql = "SELECT COUNT(*) FROM articles a
                JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = :cat_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cat_id' => $categoryId]);

        return (int)$stmt->fetchColumn();
    }

    // Похожие статьи: берём статьи из тех же категорий, что и текущая.
    // Чем больше общих категорий — тем выше статья в списке.
    public function getRelated($articleId, $limit = 3)
    {
        $sql = "SELECT a.*, COUNT(*) AS common_categories
                FROM articles a
                JOIN article_category ac ON ac.article_id = a.id
                WHERE ac.category_id IN (
                    SELECT category_id FROM article_category WHERE article_id = :current_id
                )
                AND a.id != :exclude_id
                GROUP BY a.id
                ORDER BY common_categories DESC, a.created_at DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':current_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}