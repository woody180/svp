<nav uk-navbar class="uk-flex-1">
    <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
            <li class="uk-active"><a href="<?= baseUrl() ?>">მთავარი</a></li>
            <li><a href="<?= baseUrl("categories/შესავალი") ?>">შესავალი</a></li>
            <li>
                <a href="<?= baseUrl("categories/ვექტორები") ?>">ვექტორები <span uk-navbar-parent-icon></span></a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li><a href="<?= baseUrl("categories/სმენის") ?>">სმენის</a></li>
                        <li><a href="<?= baseUrl("categories/ყნოსვითი") ?>">ყნოსვის</a></li>
                        <li><a href="<?= baseUrl("categories/ვიზუალური") ?>">ვიზუალური</a></li>
                        <li><a href="<?= baseUrl("categories/ორალური") ?>">ორალური</a></li>
                        <li><a href="<?= baseUrl("categories/ორალური") ?>">ურეთრალური</a></li>
                        <li><a href="<?= baseUrl("categories/კანის") ?>">კანის</a></li>
                        <li><a href="<?= baseUrl("categories/ანალური") ?>">ანალური</a></li>
                        <li><a href="<?= baseUrl("categories/კუნთის") ?>">კუნთის</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="<?= baseUrl("categories/კომბინაციები") ?>">კომბინაციები</a></li>
            <li>
                <a href="<?= baseUrl("categories/სხვადასხვა") ?>">სხვადასხვა <span uk-navbar-parent-icon></span></a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li><a href="<?= baseUrl("categories/დიაგნოსტიკა") ?>">დიაგნოსტიკა</a></li>
                        <li><a href="<?= baseUrl("categories/დაზიანებები") ?>">დაზიანებები</a></li>
                        <li><a href="<?= baseUrl("categories/ბავშვები") ?>">ბავშვები</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="<?= baseUrl("categories/ვიდეო") ?>">ვიდეო</a></li>
            <li><a href="<?= baseUrl("categories/სერვისები") ?>">სერვისები</a></li>
        </ul>
    </div>
</nav>