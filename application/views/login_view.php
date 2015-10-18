<style>
	a { padding-left: 15px; }
</style>
<div class="container">
	<h2>Авторизация</h2><br>
	<div class="row">
		<form role="form" method="POST"   >
			<div class="form-group">
				<label for="exampleInputEmail1">Логин</label>
				<input type="text" class="form-control" id="exampleInputEmail1" name="login" placeholder="Введите логин" required>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Пароль</label>
				<input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Введите пароль" required>
			</div>

			<input name="submit" type="submit" class="btn btn-default" value="Авторизация">
			<a href="registration"> Ещё не зарегестрированы? </a>
		</form>
	</div>
</div>
