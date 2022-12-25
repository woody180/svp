<?= $this->layout('partials/template') ?>


<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container min-height">
        
        <div class="uk-flex uk-flex-middle uk-flex-between">
            <div>
                <h3>ახალი სტატია</h3>
            </div>
        </div>
        
        
        
        <?php if (hasFlashData('success')): ?>
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><?= getFlashData('success') ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (hasFlashData('message')): ?>
        <div class="uk-alert-primary" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><?= getFlashData('message') ?></p>
        </div>
        <?php endif; ?>
        
        
        
        <div>
            <form enctype='multipart/form-data' action="<?= baseUrl(urlSegments(1, true)) ?>" class="uk-grid-match uk-child-width-1-1" method="POST" uk-grid>
                
                <?= setMethod('post') ?>
                <?= csrf_field() ?>
                
                <div>
                    <label class="uk-form-label">სათაური</label>
                    <input type="text" class="uk-input uk-border-rounded" name="title" value="<?= getForm('title') ?>">
                    <?= show_error('errors', 'title') ?>
                </div>
                
                <div>
                    <label for="" class="uk-form-label">კატეგორიები</label>
                    <select name="categories[]" class="svp-category-select uk-select uk-border-rounded" multiple>
                        <option value=""></option>
                        <?php foreach($categories as $cat): ?>
                            <option <?= in_array($cat->id, getForm('categories') ?? []) ? 'selected' : '' ?> value="<?= $cat->id ?>"><?= trim($cat->title) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= show_error('errors', 'categories') ?>
                </div>
                
                <div>
                    <label class="js-upload uk-placeholder uk-text-center uk-display-block uk-border-rounded">
                        <span uk-icon="icon: cloud-upload"></span>
                        <span class="uk-text-middle heading-font">სტატიის სურათის ატვირთვა</span>
                        <div uk-form-custom>
                            <input type="file" name="thumbnail">
                        </div>
                    </label>
                </div>
                
                <div>
                    <label class="uk-form-label">აღწერა</label>
                    <textarea type="text" class="uk-textarea uk-border-rounded uk-height-small" name="description"><?= getForm('description') ?></textarea>
                    <?= show_error('errors', 'description') ?>
                </div>
                
                <div>
                    <label class="uk-form-label">სტატიის ტექსტი</label>
                    <textarea type="text" class="uk-textarea uk-border-rounded uk-height-small tinymce-editalbe-area" name="body"></textarea>
                    <?= show_error('errors', 'content') ?>
                </div>
                
                
                <div>
                    <button class="uk-button uk-button-primary">
                        <span class="heading-font">სტატიის შენახვა</span>
                    </button>
                </div>

            </form>
        </div>
    
    </div>
</section>

<?= $this->stop(); ?>