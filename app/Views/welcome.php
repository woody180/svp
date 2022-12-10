<?php $this->layout('partials/template', ['title' => $title]) ?>

<?php $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container">

        <ul>
            <?php foreach ($latest as $la): ?>
            <li>
                <div>
                    <?= $la->title ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    
    </div>
</section>

<?php $this->stop() ?>