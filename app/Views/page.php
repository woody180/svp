<?php $this->layout('partials/template') ?>

<?php $this->start('mainSection') ?>
<section class="uk-section" data-bg-color="#f7f7f7">
    <div class="uk-container">

        <div id="svp-article-container" class="uk-grid" uk-grid>
            
            <div class="uk-width-2-3@m">
                <div class="uk-card uk-card-body uk-border-rounded uk-overflow-hidden uk-background-default">
                    <?= img(['src' => $page->thumbnail, 'class' => 'uk-display-block uk-margin-bottom uk-width-1-1 uk-border-rounded'], true) ?>
                    
                    <h1 class="uk-text-lead"><?= $page->title ?></h1>
                    <hr class="uk-divider-small">
                    
                    <div class="svp-page-body">
                        <?= $page->body ?>
                    </div>
                </div>
            </div>
            
            <?= $this->insert('partials/sidebar') ?>
            
        </div>

    </div>
</section>
<?php $this->stop() ?>