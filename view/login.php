<header class="navbar navbar-static-top"></header>
<div class="col-sm-offset-4 col-sm-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h1 class="panel-title"><i class="fa fa-lock"></i> Please enter your login details.</h1>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="input-username">Username</label>
				<div class="input-group">
				<span class="input-group-addon">
					<i class="glyphicon glyphicon-user"></i>
				</span>
					<input type="text" class="form-control" name="username" placeholder="Username" id="username"/>
				</div>
				<label for="input-username">Password</label>

				<div class="input-group">
				<span class="input-group-addon">
					<i class="glyphicon glyphicon-lock"></i>
				</span>
					<input type="password" class="form-control" placeholder="Password" name="password" id="password"/>
				</div>
			</div>

			<div class="text-right">
					<a href="#" class="newuser">Registration </a>
					<a href="#" class="signin" style="display: none;">Sign In </a>

				<button type="button" class="btn btn-default" value="Login" id="login">
					<i class="glyphicon glyphicon-check"></i> Login
				</button>

				<button type="button" class="btn btn-default" style="display: none;" id="registration">
					<i class="glyphicon glyphicon-registration-mark"></i> Registration
				</button>
			</div>
		</div>
	</div>
</div>
