{include file="_top.tpl"}

<div class="row">
	<div class="col-md-5 mx-auto">
		<div id="first">
			<div class="myform form ">
				<div class="logo mb-3">
					<div class="col-md-12 text-center">
						<h1>Connexion</h1>
					</div>
				</div>
				{if $error}
					<div class="alert alert-danger" role="alert">
						{$error}
					</div>
				{/if}
				{if $login and $pass}
					<div class="alert alert-success" role="alert">
						Veuillez bien noter ses accès :<br>Identifiant : {$login}<br>Mot de passe : {$pass}
					</div>
				{/if}
				<form action="account/login/" method="post" name="login">
					<div class="form-group">
						<label for="exampleInputEmail1">Identifiant</label>
						<input type="text" name="login"  class="form-control" placeholder="Identifiant">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Mot de passe</label>
						<input type="password" name="pass" id="password"  class="form-control" placeholder="Enter Password">
					</div>
					<div class="col-md-12 text-center ">
						<button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Se connecter</button>
					</div>
					<div class="col-md-12 ">
						<div class="login-or">
							<hr class="hr-or">
							<span class="span-or">ou</span>
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<p class="text-center">
							<a href="account/registration/" class="google btn mybtn">
								<i class="fa fa-google-plus"></i> Créer un compte automatiquement
							</a>
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="_bot.tpl"}