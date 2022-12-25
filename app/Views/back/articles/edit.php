<?= $this->layout('partials/template') ?>


<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container min-height">
        
        <ul class="uk-list uk-list-striped body-font">
            <?php foreach ($list->data as $article): ?>
            <li>
                <div class="uk-flex uk-flex-middle uk-flex-between">
                    <div class="uk-text-small"><?= $article->title ?></div>
                    
                    <div class="svp-action-buttons uk-flex uk-flex-middle">
                        <a class="uk-display-block uk-margin-small-right" href="<?= baseUrl("article/{$article->id}/edit") ?>" uk-icon="icon: pencil"></a>
                        <a class="uk-display-block" href="#" uk-icon="icon: trash"></a>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        
        <?php if ($list->pager): ?>
        <div class="uk-flex uk-flex-center">
            <?= $list->pager ?>
        </div>
        <?php endif; ?>
    
    </div>
</section>

<?= $this->stop(); ?>