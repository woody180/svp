<?php $this->layout('partials/template') ?>

<?php $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container min-height">

        <ul class="uk-list uk-list-striped">
            <?php foreach ($results as $result): ?>
            <li class="svp-search-result">
                <div class="uk-flex uk-flex-middle uk-flex-between">
                    <div class="uk-flex">
                        
                        <a class="uk-display-block" href="<?= baseUrl("article/{$result->url}") ?>">
                            <?= img(['src' => $result->thumbnail, 'class' => 'uk-display-block uk-object-cover uk-border-rounded'], true) ?>
                        </a>
                        
                        <div class="uk-margin-left">
                            <a href="<?= baseUrl("article/{$result->url}") ?>" class="heading-font uk-text-small uk-text-bold uk-link-reset"><?= $result->title ?></a>
                            <p class="uk-text-xsmall uk-text-italic body-font svp-category-links" data-category-url="<?= $result->cat_url ?>"><?= $result->cat_title ?></p>
                        </div>
                    </div>
                    
                    <?php if ($isAdmin): ?>
                    <div class="svp-action-buttons uk-flex uk-flex-middle">
                        <a class="uk-display-block uk-margin-small-right" href="<?= baseUrl("article/{$result->id}/edit") ?>" uk-icon="icon: pencil"></a>
                        
                        <form method="POST" action="<?= baseUrl("article/{$result->id}") ?>">
                            <?= setMethod('delete') ?>
                            <button type="submit" class="uk-display-block" href="#" uk-icon="icon: trash" onclick="return confirm('დარწმუნებული ხარ?')"></button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>


    </div>
</section>
<?php $this->stop() ?>