{strip}
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>{$title}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/flexslider.css">
        <link rel="shortcut icon" href="/favicon.ico">
        {*<link rel="stylesheet" href="/css/flexslider-rtl-min.css">*}
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">
                <img src="/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                anners
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        {if $is_admin_panel && isset($is_auth)}
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {$username}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a href="/admin" class="dropdown-item">{$localisation.index.menu.list}</a>
                                    <button class="dropdown-item" type="button" disabled>{$localisation.index.menu.settings}</button>
                                    <button class="dropdown-item" type="button" id="exit">{$localisation.index.menu.exit}</button>
                                </div>
                            </div>
                            {else}
                                {if !$is_admin_panel}<a class="btn btn-sm btn-outline-success" href="/admin">{$localisation.main_temp.all.admin_panel}</a>{/if}
                        {/if}
                    </li>
                </ul>
            </div>
        </nav>
        <div class="main-container">
        {include file="$main_temp.tpl"}
        </div>


        <footer class="page-footer font-small bg-light ">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">
                <a href="/"><i class="fa fa-github"></i></a>
            </div>
            <!-- Copyright -->

        </footer>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.cookie.js"></script>
        {*Подключаем файл локализации*}
        <script src="/localisations/js/RU.js"></script>
        <link rel="stylesheet" href="/css/croppie.css"/>
        <script src="/js/croppie.js"></script>
        <script src="/js/jquery.flexslider-min.js"></script>
        <script src="/js/script.js"></script>
        {if strpos($main_temp, 'admin/add') !== false || strpos($main_temp, 'admin/edit') !== false}
            {include file="$DOCUMENT_ROOT/app/views/admin/js.tpl"}
        {/if}
        {if strpos($main_temp, 'main/index') !== false}
            {include file="$DOCUMENT_ROOT/app/views/main/js.tpl"}
        {/if}
    </body>
    </html>
{/strip}