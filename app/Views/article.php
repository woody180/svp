<?php $this->layout('partials/template') ?>

<?php $this->start('mainSection') ?>
<section class="uk-section" data-bg-color="#f7f7f7">
    <div class="uk-container">

        <div id="svp-article-container" class="uk-grid" uk-grid>
            
            <div class="uk-width-2-3@m">
                <div class="uk-card uk-card-body uk-border-rounded uk-overflow-hidden uk-background-default">
                    <?= img(['src' => $article->thumbnail, 'class' => 'uk-display-block uk-margin-bottom uk-width-1-1'], true) ?>
                    
                    <div class="svp-article-body">
                        <?= $article->body ?>
                    </div>
                </div>
            </div>
            
            <?= $this->insert('partials/sidebar') ?>
            
        </div>

    </div>
</section>
<?php $this->stop() ?>