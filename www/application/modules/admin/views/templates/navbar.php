<!-- Static navbar -->
<div class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin/"><?= str_ireplace('http://', '', substr(base_url(), 0, -1)); ?></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php
                if (strpos(current_url(), 'admin/main')) {
                    echo "class=\"active\"";
                }
                ?> ><a href="/admin/main">Главная</a></li>
                <li <?php
                if (strpos(current_url(), 'admin/hotels')) {
                    echo "class=\"active\"";
                }
                ?> ><a href="/admin/hotels">Отели</a></li>
                <li <?php
                if (strpos(current_url(), 'admin/tours')) {
                    echo "class=\"active\"";
                }
                ?> ><a href="/admin/tours">Туры</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Модули <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/admin/blog">Блог</a></li>
                        <li><a href="/admin/news">Новости</a></li>
                        <li><a href="/admin/contacts">Контакты</a></li>
                        <li><a href="/admin/backcall">Обратный звонок</a></li>
                        <li><a href="/admin/feedback">Обратная связь</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="/admin/requests">Запросы <span style="background-color:green;" class="badge"><?php
                            if (isset($msgs)) {
                                echo $msgs;
                            }
                            ?></span></a></li>
                <li><a href="/" target="_blank">Перейти на сайт <span class='glyphicon glyphicon-new-window'></span></a></li>
                <li><a href="<?= '/admin/logout' ?>">Выход</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</div>