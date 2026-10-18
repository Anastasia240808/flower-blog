{* Карточка статьи. Подключается так: {include file="partials/article_card.tpl" article=$article} *}
<article class="card">
    <a href="/?route=article&amp;id={$article.id}" class="card__image">
        {if $article.image}
           <img src="/assets/images/{$article.image}" alt="{$article.title}" loading="lazy">
        {/if}
    </a>
    <div class="card__body">
        <h3 class="card__title">
            <a href="/?route=article&amp;id={$article.id}" class="card__link">{$article.title}</a>
        </h3>
        <p class="card__desc">{$article.description}</p>
        <div class="card__meta">
            <span class="meta-item">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                {$article.created_at|date_format:"d.m.Y"}
            </span>
            <span class="meta-item">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                {$article.views}
            </span>
        </div>
    </div>
</article>