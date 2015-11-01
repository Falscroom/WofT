<style>
    p { padding-bottom: 1px; }
</style>
<div class="container">
    <div class="row">
        <h2>Профиль <?php echo $data["user"]["login"] ?></h2>
        <p><div class="col-md-6">Фамилия Имя Отчество</div><div class="col-md-6"><?php echo $data["user"]["user_info"] ?></div> </p>
        <p><div class="col-md-6">Контакты</div><div class="col-md-6"><?php echo $data["user"]["contacts"] ?></div> </p>
        <p><div class="col-md-6">Статус</div><div class="col-md-6"><?php
            switch($data["user"]["if_stuff"]) {
                case true: echo("Преподаватель"); if(!($data["user"]["rights"] & U_EDIT)) { echo(" (неподтверждено!)");
                           if($data["rights"] == U_PROFESSOR)
                                echo ("<p><a href='/admin/upgrade_rights/{$data["user"]["id"]}'>Подтвердить</a></p>"); }
                    break;
                case false: echo("Пользователь");
                    break;
            }
            ?></div></p>
        <?php
        if($data["rights"] == U_PROFESSOR && $data["user"]["login"] == $data["login"])
            echo " <p><div class='col-md-6'><a href='/admin'>Перейти к администрированию</a></div></p>";
        ?>
        <p><div><a href="/main/logout">Выйти из профиля</a></div></p>
    </div>
</div>