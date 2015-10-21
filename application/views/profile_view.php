<style>
    p { padding-bottom: 1px; }
</style>
<div class="container">
    <div class="row">
        <h2>Профиль <?php echo $data["user"]["login"] ?></h2>
        <p><div class="col-md-6">Фамилия Имя Отчество</div><div class="col-md-6"><?php echo $data["user"]["user_info"] ?></div> </p>
        <p><div class="col-md-6">Контакты</div><div class="col-md-6"><?php echo $data["user"]["contacts"] ?></div> </p>
        <p><div class="col-md-6">Статус</div><div class="col-md-6"><?php
            if($data["user"]["if_stuff"])
                echo "Преподаватель";
            else
                echo "Пользователь";
            if(!$data["user"]["rights"])
                echo " (ваш статус неподтвержден!)";
            ?></div> </p>
        <?php
        if($data["rights"])
            echo " <p><div class='col-md-6'><a href='/admin'>Перейти к администрированию</a></div></p>";
        ?>
        <p><div><a href="/main/logout">Выйти из профиля</a></div></p>
    </div>
</div>