<?php
// создаёт таблицы и заполняет их тестовыми данными
// Запуск: php src/seed.php  (в Docker: docker compose exec web php src/seed.php)

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/../database/seed_data.php';

echo "Начинаем заполнение базы данных...\n";

// 1. Создаём таблицы из schema.sql
$schema = file_get_contents(__DIR__ . '/../database/schema.sql');
foreach (explode(';', $schema) as $query) {
    if (trim($query) !== '') {
        $pdo->exec($query);
    }
}

// 2. Очищаем таблицы, чтобы сидер можно было запускать много раз
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE article_category");
$pdo->exec("TRUNCATE TABLE articles");
$pdo->exec("TRUNCATE TABLE categories");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

// 3. Добавляем категории и запоминаем их id
$catStmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
$catIds = [];
foreach ($categories as $cat) {
    $catStmt->execute($cat);
    $catIds[] = $pdo->lastInsertId();
}

// 4. Добавляем статьи и связываем их с категориями
$artStmt = $pdo->prepare(
    "INSERT INTO articles (title, description, text, image, views, created_at)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$linkStmt = $pdo->prepare("INSERT INTO article_category (article_id, category_id) VALUES (?, ?)");

foreach ($articles as $art) {
    // Дата публикации = сейчас - days_ago дней
    $createdAt = date('Y-m-d H:i:s', strtotime('-' . $art['days_ago'] . ' days'));

    $artStmt->execute([
        $art['title'],
        $art['description'],
        $art['text'],
        $art['image'],
        $art['views'],
        $createdAt,
    ]);
    $articleId = $pdo->lastInsertId();

    foreach ($art['categories'] as $catIndex) {
        $linkStmt->execute([$articleId, $catIds[$catIndex]]);
    }
}

echo "Готово!\n";
echo "Категорий: " . count($categories) . "\n";
echo "Статей: " . count($articles) . "\n";