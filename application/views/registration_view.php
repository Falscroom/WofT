<div class="container">
    <h2>Регистрация</h2><br>
    <div class="row">
        <form role="form" method="POST"   >
            <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input type="login" class="form-control" id="exampleInputEmail1" name="login" placeholder="Введите ваш логин" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="pass" placeholder="Введите ваш пароль" required>
            </div>

            <div class="form-group">
                <label for="passtwo">Повторите пароль</label>
                <input type="password" class="form-control" id="passtwo" name="passtwo" placeholder="Повторите ваш пароль" required>
            </div>

            <div class="form-group">
                <label for="if_stuff">Вы преподаватель?</label>
                <select class="form-control" name="if_stuff" id="if_stuff">
                    <option>Нет</option>
                    <option>Да</option>
                </select>
            </div>
            <div class="form-group">
                <label for="group">Выберите группу (если знаете)</label>
                <select class="form-control" name="group" id="group">
                    <option>Не знаю / Я преподаватель</option>
                    <?php
                    foreach($data["options"] as $group) {
                        echo "<option>" . $group["name"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="FIO">ФИО</label>
                <input type="text" class="form-control" id="NMF" name="nmf" placeholder="Ваше фамилия имя и отчество" required>
            </div>

            <div class="form-group">
                <label for="info">Контактная информация</label>
                <input type="text" class="form-control" id="info" name="info" placeholder="Как мы можем найти вас?" required>
            </div>


            <input name="submit" type="submit" class="btn btn-default" value="Авторизация">
        </form>
    </div>
</div>
<br>
<br>
<br>
<br>