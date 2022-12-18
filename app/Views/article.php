<?php $this->layout('partials/template', ['title' => $title, 'description' => $this->e(mb_strimwidth($article->description, 0, 155))]) ?>

<?= $this->start('og_meta') ?>
<meta property="og:url" content="<?= baseUrl(urlSegments(null, true)) ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?= $article->title ?>" />
<meta property="og:description" content="<?= $this->e(mb_strimwidth($article->description, 0, 155)) ?>" />
<meta property="og:image" content="<?= assetsUrl("tinyeditor/filemanager/files/".$article->thumbnail) ?>" />
<?= $this->stop() ?>

<?php $this->start('mainSection') ?>
<section class="uk-section" data-bg-color="#f7f7f7">
    <div class="uk-container">

        <div id="svp-article-container" class="uk-grid" uk-grid>
            
            <div class="uk-width-2-3@m">
                <div class="uk-card uk-card-body uk-border-rounded uk-overflow-hidden uk-background-default">
                    <?= img(['src' => $article->thumbnail, 'class' => 'uk-border-rounded uk-display-block uk-margin-bottom uk-width-1-1'], true) ?>
                    
                    
                    <div class="svp-article-body">
                        <div class="uk-padding-small uk-text-italic uk-background-muted uk-border-rounded uk-text-small uk-flex">კატეგორიები: <div class="uk-margin-small-left svp-category-links"><?= $categories ?></div></div>
                       
                        <h1 class="uk-text-lead"><?= $article->title ?></h1>
                        <hr class="uk-divider-small">
                        
                        <?= $article->body ?>
                    </div>
                </div>
            </div>
            
            <?= $this->insert('partials/sidebar') ?>
            
        </div>

    </div>
</section>
<?php $this->stop() ?>