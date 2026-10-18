<?php

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Article.php';

class ArticleController
{
    private $smarty;
    private $pdo;

    public function __construct($smarty, $pdo)
    {
        $this->smarty = $smarty;
        $this->pdo = $pdo;
    }

    public function index()
    {
        $categoryModel = new Category($this->pdo);
        $articleModel = new Article($this->pdo);

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Если статьи нет - показываем страницу 404
        $article = $articleModel->getById($id);
        if (!$article) {
            http_response_code(404);
            $this->smarty->display('pages/404.tpl');
            return;
        }

        // Засчитываем просмотр и обновляем число в уже полученной статье
        $articleModel->increaseViews($id);
        $article['views'] = $article['views'] + 1;

        // Текст в базе хранится с пустыми строками между абзацами - делим его на абзацы
        $paragraphs = explode("\n\n", $article['text']);

        $this->smarty->assign('article', $article);
        $this->smarty->assign('paragraphs', $paragraphs);
        $this->smarty->assign('categories', $categoryModel->getByArticleId($id));
        $this->smarty->assign('relatedArticles', $articleModel->getRelated($id, 3));

        $this->smarty->display('pages/article.tpl');
    }
}