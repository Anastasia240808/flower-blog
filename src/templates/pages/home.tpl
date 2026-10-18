{extends file="layouts/base.tpl"}

{block name=title}Блог о цветах - уход, букеты и идеи для сада{/block}

{block name=content}

    {* Приветственный блок *}
    <section class="hero">
        <div class="hero__content">
            <span class="hero__badge">Цветы · сад · флористика</span>
            <h1 class="hero__title">Всё о цветах - от подоконника до сада</h1>
            <p class="hero__subtitle">
                Советы по уходу, идеи для букетов и вдохновение для вашего сада.
                Читайте, пробуйте и выращивайте.
            </p>

            {* Быстрые ссылки на категории *}
            <div class="hero__tags">
                {foreach $categories as $category}
                    <a href="/?route=category&amp;id={$category.id}" class="tag">{$category.name}</a>
                {/foreach}
            </div>
        </div>

        <div class="hero__stats">
            <div class="stat">
                <span class="stat__number">{$totalArticles}</span>
                <span class="stat__label">Статьи</span>
            </div>
            <div class="stat">
                <span class="stat__number">{$categories|count}</span>
                <span class="stat__label">Категории</span>
            </div>
        </div>
    </section>

    {if $categories}

        {foreach $categories as $category}
            <section class="category">

                {* Шапка категории: название + кнопка *}
                <div class="category__header">
                    <div class="category__info">
                        <h2 class="category__title">{$category.name}</h2>
                        <p class="category__desc">{$category.description}</p>
                    </div>
                    <a href="/?route=category&amp;id={$category.id}" class="btn btn--dark">
                        Все статьи
                        <span class="btn__arrow">→</span>
                    </a>
                </div>

                {* Три последних статьи категории *}
                <div class="articles">
                    {foreach $category.latest_articles as $article}
                        {include file="partials/article_card.tpl" article=$article}
                    {/foreach}
                </div>

            </section>
        {/foreach}

    {else}
        <p class="empty">Статей пока нет. Запустите сидинг: <code>php src/seed.php</code></p>
    {/if}

{/block}