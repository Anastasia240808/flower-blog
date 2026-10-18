{extends file="layouts/base.tpl"}

{block name=title}{$article.title} - Блог о цветах{/block}
{block name=description}{$article.description}{/block}

{block name=content}

    <article class="post">

        {* Заголовок статьи *}
        <header class="post__header">
            <nav class="breadcrumbs">
                <a href="/">Главная</a>
                <span>/</span>
                {if $categories}
                    <a href="/?route=category&amp;id={$categories[0].id}">{$categories[0].name}</a>
                    <span>/</span>
                {/if}
                <span>Статья</span>
            </nav>

            {* Категории статьи *}
            <div class="post__tags">
                {foreach $categories as $category}
                    <a href="/?route=category&amp;id={$category.id}" class="tag">{$category.name}</a>
                {/foreach}
            </div>

            <h1 class="post__title">{$article.title}</h1>
            <p class="post__lead">{$article.description}</p>

            <div class="post__meta">
                <span class="meta-item">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {$article.created_at|date_format:"d.m.Y"}
                </span>
                <span class="meta-item">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Просмотров: {$article.views}
                </span>
            </div>
        </header>

        {* Изображение *}
        {if $article.image}
            <div class="post__cover">
                <img src="/assets/images/{$article.image}" alt="{$article.title}">
            </div>
        {/if}

        {* Текст статьи *}
        <div class="post__text">
            {foreach $paragraphs as $paragraph}
                <p>{$paragraph}</p>
            {/foreach}
        </div>

    </article>

    {* Похожие статьи *}
    {if $relatedArticles}
        <section class="related">
            <h2 class="related__title">Похожие статьи</h2>
            <div class="articles">
                {foreach $relatedArticles as $related}
                    {include file="partials/article_card.tpl" article=$related}
                {/foreach}
            </div>
        </section>
    {/if}

{/block}