<?php

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Article.php';

class CategoryController
{
    private $smarty;
    private $pdo;

    // Сколько статей показываем на одной странице
    private $perPage = 6;

    public function __construct($smarty, $pdo)
    {
        $this->smarty = $smarty;
        $this->pdo = $pdo;
    }

    public function index()
    {
        $categoryModel = new Category($this->pdo);
        $articleModel = new Article($this->pdo);

        // Получаем параметры из URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Разрешены только две сортировки, всё остальное считаем по дате
        if ($sort !== 'views') {
            $sort = 'date';
        }

        // Получаем категорию
        $category = $categoryModel->getById($id);
        if (!$category) {
            http_response_code(404);
            $this->smarty->display('pages/404.tpl');
            return;
        }

        // Пагинация
        $totalArticles = $articleModel->getTotalByCategory($id);
        $totalPages = (int)ceil($totalArticles / $this->perPage);

        // Номер страницы
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        if ($page < 1) {
            $page = 1;
        }

        // Получаем статьи
        $articles = $articleModel->getByCategory($id, $sort, $page, $this->perPage);

        // Передаем данные в шаблон
        $this->smarty->assign('category', $category);
        $this->smarty->assign('articles', $articles);
        $this->smarty->assign('totalArticles', $totalArticles);
        $this->smarty->assign('currentSort', $sort);
        $this->smarty->assign('currentPage', $page);
        $this->smarty->assign('totalPages', $totalPages);

        $this->smarty->display('pages/category.tpl');
    }
}