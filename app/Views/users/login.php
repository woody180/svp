<?php $this->layout('partials/template', ['title' => $title]) ?>

<?= $this->start('mainSection') ?>
    
<section class="uk-section">
    <div class="uk-container uk-container-small">
        
        <div class="uk-card uk-card-default">
            <div class="uk-card-body">
                <p class="uk-text-lead">პროფილში შესვლა</p>
                
                <?php if (hasFlashData('message')): ?>
                <div class="uk-alert-primary" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p><?= getFlashData('message'); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if (hasFlashData('success')): ?>
                <div class="uk-alert-success" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p><?= getFlashData('success'); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if (getFlashData('error')): ?>
                <div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p><?= getFlashData('error'); ?></p>
                </div>
                <?php endif; ?>
                
                <form id="alter-login-form" class="alter-login-form uk-grid-medium uk-child-width-1-1k" uk-grid action="<?= baseUrl("users/login") ?>" method="POST" accept-charset="utf-8">
                    <?= csrf_field() ?>
                    <div>
                        <label for="email" class="uk-form-label">ელ. ფოსტა</label>
                        <input id="email" type="email" name="email" class="uk-input" value="<?= getForm('email') ?>">
                        <?= show_error('errors', 'email') ?>
                    </div>
                   
                    <div>
                        <label for="password" class="uk-form-label">პაროლი</label>
                        <input id="password" type="password" name="password" class="uk-input" value="<?= getForm('password') ?>">
                        <?= show_error('errors', 'password') ?>
                    </div>
                    
                    <div id="account-buttons-set" class="uk-flex uk-flex-between uk-flex-middle">
                        <button class="uk-button uk-button-primary" type="submit">პროფილში შესვლა</button>
                        
                        <div>
                            <a class="uk-link" href="<?= baseUrl("users/register") ?>">პროფილის შექმნა</a>
                            <span>-</span>
                            <a class="uk-link" href="<?= baseUrl("users/reset") ?>">პაროლის აღდგენა</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</section>

<?= $this->stop() ?>