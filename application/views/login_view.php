<div class="container">	
		<h2>Авторизация</h2><br>
		 <div class="row">
		<form role="form" method="POST" action="/master-class/user/authUser">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Логин</label>
		    <input type="login" class="form-control" id="exampleInputEmail1" name="login" placeholder="Enter login" required>
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Пароль</label>
		    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" required>
		  </div>
		  
		  <input name="submit" type="submit" class="btn btn-default" value="Авторизация">
		</form>
		    </div>
		  </div>
		    <div class="container">
		    	<div class="row">
				  		<? 
				  				if (isset($data)){
				  					echo('<br><div class="alert alert-info" role="alert">'.$data.'</div>');
				  				}
				  		?>
		      	</div>
		     </div>
		  <br>
		  <br>
		  <br>
		  <br>