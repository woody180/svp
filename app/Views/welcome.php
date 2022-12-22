<?php $this->layout('partials/template') ?>

<?php $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container">
        
        <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slider="autoplay: true; autoplay-interval: 4000; pause-on-hover: false;">

            <ul id="svp-article-slider" class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-4@l uk-grid-match uk-grid uk-grid-medium">
                <?php foreach ($latest as $la): ?>
                <li>
                    <div class="uk-card uk-overflow-hidden uk-border-rounded">
                        <div class="uk-card-media-top uk-position-relative">
                            <a target="_blank" href="<?= baseUrl("article/{$la->url}") ?>" class="uk-position-z-index uk-position-absolute uk-width-1-1 uk-height-1-1 uk-position-top-left"></a>
                            
                            <?= img(['src' => $la->thumbnail, "class" => "uk-object-cover uk-width-1-1 uk-height-1-1", "alt" => $la->title], true) ?>
                            
                            <div class="uk-position-bottom-left uk-position-absolute uk-padding-small uk-light uk-text-xsmall uk-position-z-index body-font uk-text-italic">
                                <?php foreach (explode(',', $la->cat_title) as $catIndex => $cat): ?>
                                    <a target="_blank" href="<?= baseUrl("categories/" . explode(',', $la->cat_url)[$catIndex]) ?>">
                                        <svg width="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 374.06 373.93" fill="#fff"><g id="a"/><g id="b"><g id="c"><path d="M140.3,363.85L10.08,233.63c-11.3-11.3-13.42-27.51-4.72-36.21L197.42,5.36C201.13,1.65,206.41-.24,212.35,.02l125.52,5.55c16.4,.73,32.03,16.53,32.52,32.88l3.66,123.36c.17,5.79-1.72,10.94-5.34,14.57l-192.19,192.19c-8.7,8.7-24.91,6.58-36.21-4.72ZM296.92,56.55c-13.78,0-24.95,11.17-24.95,24.95s11.17,24.95,24.95,24.95,24.95-11.17,24.95-24.95-11.17-24.95-24.95-24.95Z"/></g></g></svg>    
                                        <span class="uk-margin-small-right"><?= $cat ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="uk-width-1-1 uk-position-absolute uk-position-top-left layer-film uk-padding-small uk-light layer-film">
                                <a class="uk-display-block uk-link-reset heading-font uk-position-z-index svp-article-slider-title uk-position-top-left"><?= $la->title ?></a>
                            </div>
                        </div>
                        
                        <div class="uk-card-body uk-padding-small uk-text-small uk-text-center">
                            <p class="uk-margin-remove body-font" data-responsive="max-width[960]; style[font-size: 10px]"><?= mb_strimwidth($la->description, 0, 100, '...') ?></p>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

        </div>
    
    </div>
</section>



<section class="uk-section" data-style="background-color: #F7F7F7">
    <div class="uk-container">
        
        <div class="uk-margin-medium-bottom">
            <h3>ბოლოს დამატებული სტატიები</h3>
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