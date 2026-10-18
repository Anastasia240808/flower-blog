<?php

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Article.php';

class HomeController
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

        // Берём только категории, в которых есть статьи
        $categories = $categoryModel->getAllWithArticles();

        // Для каждой категории получаем 3 последних статьи
        foreach ($categories as &$category) {
            $category['latest_articles'] = $articleModel->getLatestByCategory($category['id'], 3);
        }
        unset($category);

        $this->smarty->assign('categories', $categories);
        $this->smarty->assign('totalArticles', $articleModel->countAll());
        $this->smarty->display('pages/home.tpl');
    }
}