{extends file="layouts/base.tpl"}

{block name=title}Страница не найдена — Блог о цветах{/block}

{block name=content}
    <section class="not-found">
        <p class="not-found__code">404</p>
        <h1 class="not-found__title">Такой страницы не существует</h1>
        <p class="not-found__text">Возможно, ссылка устарела или в адресе есть опечатка.</p>
        <a href="/" class="btn btn--dark">На главную</a>
    </section>
{/block}