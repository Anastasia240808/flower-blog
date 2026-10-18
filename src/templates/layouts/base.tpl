<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{block name=description}Советы по уходу за цветами, идеи для букетов и вдохновение для вашего сада{/block}">
    <title>{block name=title}Блог о цветах{/block}</title>

    {* Шрифты: Fraunces для заголовков, Inter для текста *}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    {* Шапка сайта *}
    <header class="header">
        <div class="container header__inner">
            <a href="/" class="logo">
                <span class="logo__icon">
                    <svg viewBox="0 0 32 32" width="22" height="22" aria-hidden="true">
                        <g fill="#fff">
                            <circle cx="16" cy="8" r="5"/>
                            <circle cx="16" cy="24" r="5"/>
                            <circle cx="8" cy="16" r="5"/>
                            <circle cx="24" cy="16" r="5"/>
                        </g>
                        <circle cx="16" cy="16" r="4" fill="#f4b63f"/>
                    </svg>
                </span>
                <span class="logo__text">Блог о цветах</span>
            </a>
           <nav class="nav">
    <a href="/" class="nav__link nav__link--home {if $route == 'home'}is-active{/if}">Главная</a>

    {* Выпадающий список категорий *}
    <details class="dropdown">
        <summary class="nav__link {if $route == 'category'}is-active{/if}">Категории</summary>
        <div class="dropdown__menu">
            {foreach $menuCategories as $menuCategory}
                <a href="/?route=category&amp;id={$menuCategory.id}" class="dropdown__item">{$menuCategory.name}</a>
            {/foreach}
        </div>
    </details>
</nav>
        </div>
    </header>

    {* Основной контент *}
    <main class="main">
        <div class="container">
            {block name=content}{/block}
        </div>
    </main>

    {* Подвал *}
    <footer class="footer">
        <div class="container footer__inner">
            <p class="footer__logo">Блог о цветах</p>
            <p class="footer__text">© {$smarty.now|date_format:"Y"} Все права защищены.</p>
        </div>
    </footer>


    {* Закрываем выпадающее меню при клике вне его, по Esc и по выбору пункта *}
    <script>
        (function () {
            var dd = document.querySelector('.dropdown');
            if (!dd) return;
            document.addEventListener('click', function (e) {
                if (!dd.contains(e.target) || e.target.closest('.dropdown__item')) dd.removeAttribute('open');
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') dd.removeAttribute('open');
            });
        })();
    </script>

</body>
</html>