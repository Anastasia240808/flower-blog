<?php
// 1. Подключаем Smarty и базу данных
require_once __DIR__ . '/../vendor/smarty/smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../src/config/database.php';

// 2. Настраиваем Smarty
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../src/templates/');
$smarty->setCompileDir(__DIR__ . '/../src/templates/compiled/');
$smarty->setCacheDir(__DIR__ . '/../src/templates/cache/');

// Автоматически экранируем все переменные в шаблонах
$smarty->escape_html = true;

// 3. Простой роутер: смотрим параметр route в адресе (?route=article&id=5)
$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Передаем название страницы в шаблон, чтобы подсвечивать пункт меню
$smarty->assign('route', $route);
// Категории для выпадающего меню в шапке 
require_once __DIR__ . '/../src/Models/Category.php';
$menuCategoryModel = new Category($pdo);
$smarty->assign('menuCategories', $menuCategoryModel->getAllWithArticles());

switch ($route) {
    case 'home':
        require_once __DIR__ . '/../src/Controllers/HomeController.php';
        $controller = new HomeController($smarty, $pdo);
        $controller->index();
        break;

    case 'category':
        require_once __DIR__ . '/../src/Controllers/CategoryController.php';
        $controller = new CategoryController($smarty, $pdo);
        $controller->index();
        break;

    case 'article':
        require_once __DIR__ . '/../src/Controllers/ArticleController.php';
        $controller = new ArticleController($smarty, $pdo);
        $controller->index();
        break;

    default:
        // Если страница не найдена
        http_response_code(404);
        $smarty->display('pages/404.tpl');
        break;
}