<?php $this->layout('partials/template') ?>

<?php $this->start('mainSection') ?>
<section class="uk-section" data-style="background-color: #F7F7F7">
    <div class="uk-container">
        
        <div class="uk-margin-medium-bottom">
            <h3>კატეგორია: <b><?= $articles->title ?></b></h3>
            <hr class="uk-divider-small">
        </div>
        
        
        <div class="uk-grid" uk-grid>
            
            <div class="uk-width-2-3@m">
                <div>
                    
                    <div class="uk-child-width-1-2 uk-grid-match uk-grid-medium" uk-grid>
                        
                        <?php foreach ($articles->data as $article): ?>
                            <?= $this->insert('partials/cardDefault', ['data' => $article]) ?>
                        <?php endforeach; ?>
                        
                    </div>
                    
                    
                    <?php if ($articles->pager): ?>
                    <div class="uk-flex uk-flex-center uk-margin-large-top">
                        <?= $articles->pager ?>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
            
            
            <?= $this->insert('partials/sidebar') ?>
            
        </div>
    </div>
</section>

<?php $this->stop() ?>