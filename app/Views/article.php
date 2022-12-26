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
                    <?php if ($article->thumbnail): ?>
                        <?= img(['src' => $article->thumbnail, 'class' => 'uk-border-rounded uk-display-block uk-margin-bottom uk-width-1-1'], true) ?>
                    <?php endif; ?>
                    
                    
                    <div class="svp-article-body">
                        <div class="uk-padding-small uk-text-italic uk-background-muted uk-border-rounded uk-text-small uk-flex uk-flex-between">
                            <div class="uk-margin-small-left svp-category-links">კატეგორიები: <?= $categories ?></div>
                            <?php if (checkAuth([1])): ?>
                            <a href="<?= baseUrl("article/" . urlSegments('last') . "/edit") ?>" uk-icon="icon: pencil;" class="uk-icon-button"></a>
                            <?php endif; ?>
                        </div>
                       
                        <h1 class="uk-text-lead"><?= $article->title ?></h1>
                        <hr class="uk-divider-small">
                        
                        <?= relevantPath($article->body) ?>
                        
                        <div id="svp-similar-articles" class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="autoplay: true; pause-on-hover: false; autoplay-interval: 4000">
                            
                            <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-2 uk-grid-medium uk-grid">
                                <?php foreach ($similars->articles as $similar): ?>
                                <li>
                                    <div class="uk-panel uk-border-rounded uk-overflow-hidden">
                                        
                                        <a href="<?= baseUrl("article/{$similar->url}") ?>" class="uk-position-absolute uk-position-top-left uk-width-1-1 uk-height-1-1"></a>
                                        
                                        <div class="layer-film to-bottom"></div>
                                        
                                        <?= img(['src' => $similar->thumbnail], true) ?>
                                        <div class="uk-position-top-left uk-panel uk-padding-small uk-position-z-index">
                                            <p><?= $similar->title ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>

                            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

                        </div>
                        
                        
                        
                        
                    </div>
                    
                    
                    <div>
                        <div class="fb-like" data-href="<?= baseUrl(urlSegments(null, true)) ?>" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="true"></div>
                        <div class="fb-comments" data-href="<?= baseUrl(urlSegments(null, true)) ?>" data-width="" data-numposts="5"></div>
                    </div>
                </div>
            </div>
            
            <?= $this->insert('partials/sidebar') ?>
            
        </div>

    </div>
</section>
<?php $this->stop() ?>