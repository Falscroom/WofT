<style>
    p { padding-bottom: 1px; }
</style>
<div class="container">
    <div class="row">
        <h1>Профиль <?php echo $data["user"]["login"] ?></h1>
        <p><div class="col-md-6">Фамилия Имя Отчество</div><div class="col-md-6"><?php echo $data["user"]["user_info"] ?></div> </p>
        <p><div class="col-md-6">Контакты</div><div class="col-md-6"><?php echo $data["user"]["contacts"] ?></div> </p>
        <p><div><a href="/main/logout">Выйти из профиля</a></div></p>
    </div>
</div>