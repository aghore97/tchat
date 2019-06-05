{include file="__head.tpl"}
<body>
<div class="container" style="background-color:white;">
<header>
	{if $session.user_id}
		<div class="col-md-12 mb-3">
			<p class="text-center">
				<a href="account/logout/" class="google btn mybtn" style="width:20%;">
					<i class="fa fa-google-plus"></i> Déconnexion
				</a>
			</p>
		</div>
	{/if}
</header>