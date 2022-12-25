<?= $this->layout('partials/template') ?>


<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container min-height">
        
        <div class="uk-flex uk-flex-middle uk-flex-between">
            <div>
                <h3>სტატიები</h3>
            </div>
            
            
            <div>
                <a class="uk-button uk-button-primary body-font uk-button-icon uk-button-icon-left" href="<?= baseUrl("article/new") ?>">
                    <span>ახალი სტატიის დამატება</span>
                    <span uk-icon="icon: plus;"></span>
                </a>
            </div>
        </div>
        
        
        <ul class="uk-list uk-list-striped body-font">
            <?php foreach ($list->data as $article): ?>
            <li>
                <div class="uk-flex uk-flex-middle uk-flex-between">
                    <div class="uk-text-small"><?= $article->title ?></div>
                    
                    <div class="svp-action-buttons uk-flex uk-flex-middle">
                        <a class="uk-display-block uk-margin-small-right" href="<?= baseUrl("article/{$article->id}/edit") ?>" uk-icon="icon: pencil"></a>
                        
                        <form method="POST" action="<?= baseUrl("article/{$article->id}") ?>">
                            <?= setMethod('delete') ?>
                            <button type="submit" class="uk-display-block" href="#" uk-icon="icon: trash" onclick="return confirm('დარწმუნებული ხარ?')"></button>
                        </form>
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