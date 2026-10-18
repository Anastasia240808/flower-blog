{extends file="layouts/base.tpl"}

{block name=title}{$category.name} — Блог о цветах{/block}
{block name=description}{$category.description}{/block}

{block name=content}

    {* Шапка категории *}
    <section class="page-head">
        <nav class="breadcrumbs">
            <a href="/">Главная</a>
            <span>/</span>
            <span>{$category.name}</span>
        </nav>
        <h1 class="page-head__title">{$category.name}</h1>
        <p class="page-head__desc">{$category.description}</p>
    </section>

    {* Панель сортировки *}
    <div class="toolbar">
        <p class="toolbar__count">Статей в категории: <strong>{$totalArticles}</strong></p>

        <div class="sort">
            <span class="sort__label">Сортировка:</span>
            <div class="segmented">
                <a href="/?route=category&amp;id={$category.id}&amp;sort=date"
                   class="segmented__item {if $currentSort == 'date'}is-active{/if}">По дате</a>
                <a href="/?route=category&amp;id={$category.id}&amp;sort=views"
                   class="segmented__item {if $currentSort == 'views'}is-active{/if}">По просмотрам</a>
            </div>
        </div>
    </div>

    {if $articles}
        <div class="articles">
            {foreach $articles as $article}
                {include file="partials/article_card.tpl" article=$article}
            {/foreach}
        </div>

        {* Пагинация *}
        {if $totalPages > 1}
            <nav class="pagination">
                {if $currentPage > 1}
                    <a class="pagination__item pagination__item--wide"
                       href="/?route=category&amp;id={$category.id}&amp;sort={$currentSort}&amp;page={$currentPage-1}">← Назад</a>
                {/if}

                {for $p=1 to $totalPages}
                    {if $p == $currentPage}
                        <span class="pagination__item is-active">{$p}</span>
                    {else}
                        <a class="pagination__item"
                           href="/?route=category&amp;id={$category.id}&amp;sort={$currentSort}&amp;page={$p}">{$p}</a>
                    {/if}
                {/for}

                {if $currentPage < $totalPages}
                    <a class="pagination__item pagination__item--wide"
                       href="/?route=category&amp;id={$category.id}&amp;sort={$currentSort}&amp;page={$currentPage+1}">Вперёд →</a>
                {/if}
            </nav>
        {/if}
    {else}
        <p class="empty">В этой категории пока нет статей.</p>
    {/if}

{/block}