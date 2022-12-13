 <div>
    <div class="uk-card uk-card-default svp-default-card">
        <div class="uk-card-media-top">
            
            <a class="link" href="<?= baseUrl("article/{$data->url}") ?>"></a>
            
            <?= img(['src' => $data->thumbnail], true) ?>
            
            <div class="uk-position-bottom-left uk-padding-small uk-light uk-position-z-index uk-text-xsmall">
                კატეგორიები: <?= $data->categories ?>
            </div>
            
        </div>
        <div class="uk-card-body">
            
            <a class="uk-card-title uk-link-reset uk-margin-small-bottom uk-display-block" href="<?= baseUrl("article/{$data->url}") ?>"><?= $data->title ?></a>
            
            <?php if (!empty($data->description)): ?>
                <p class="uk-margin-remove"><?= strip_tags(mb_strimwidth($data->description, 0, 120, '...')) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>