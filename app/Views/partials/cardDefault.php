 <div>
    <div class="uk-card uk-card-default svp-default-card">
        <div class="uk-card-media-top">
            
            <a class="link" href="<?= baseUrl("article/{$data->url}") ?>"></a>
            
            <?= img(['src' => $data->thumbnail], true) ?>
            
            <div class="svp-card-categories uk-position-bottom-left uk-padding-small uk-light uk-position-z-index uk-text-xsmall">
                <span><?= $data->categories ?></span>
                <div class="svp-links"></div>
            </div>
            
        </div>
        <div class="uk-card-body" data-responsive="max-width[960]; style[padding: 10px;]">
            
            <a class="uk-card-title uk-link-reset uk-margin-small-bottom uk-display-block" data-responsive="max-width[960]; style[font-size: 11px;]" href="<?= baseUrl("article/{$data->url}") ?>"><?= $data->title ?></a>
            
            <?php if (!empty($data->description)): ?>
                <p class="uk-margin-remove" data-responsive="max-width[960]; style[font-size: 10px;]"><?= strip_tags(mb_strimwidth($data->description, 0, 120, '...')) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>