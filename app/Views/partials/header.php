<div id="svp-header">

    <div class="uk-section-xsmall">
        <div class="uk-container">
            <div class="uk-flex uk-flex-middle uk-flex-center">
                <a href="<?= baseUrl() ?>" class="uk-display-inline-block" title="<?= APPNAME ?>">
                    <?= img(['src' => 'images/svp-logo.png', 'width' => '300', 'alt' => APPNAME]) ?>
                </a>
            </div>
        </div>
    </div>

    <div class="navigation-section uk-background-default" uk-sticky="offset: 0">
        <div class="uk-container">
            <div class="uk-flex uk-flex-middle" data-style="align-items: stretch;">

                <div class="svp-header-socials uk-visible@m">
                    <a href="#" uk-icon="icon: facebook; ratio: .8"></a>
                    <a href="#" uk-icon="icon: twitter; ratio: .8"></a>
                    <a href="#" uk-icon="icon: youtube; ratio: .8"></a>
                    <a href="#" uk-icon="icon: pinterest; ratio: .8"></a>
                </div>

                <div class="uk-visible@m svp-nav-wrapper">
                    <?= $this->insert('partials/navbar') ?>
                </div>


                <div class="uk-flex-1 svp-search">
                    <form class="uk-search uk-search-default uk-width-1-1">
                        <span class="uk-search-icon-flip" uk-search-icon></span>
                        <input class="uk-search-input uk-width-1-1" type="search" placeholder="ძიება" aria-label="Search">
                    </form>
                </div>

                <a uk-toggle href="#svp-mobile-nav-offcanvas" uk-icon="icon: menu;" class="uk-hidden@m"></a>

            </div>
        </div>
    </div>
</div>