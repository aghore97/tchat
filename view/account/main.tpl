{include file="../_top.tpl"}

<script type="">
$(document).ready(function() {
    $('#messages').DataTable();
	$('#users').DataTable();
} );
</script>

<div class="row">
	<div class="col-md-8 mx-auto">
		<div class="col-md-12">
			<div id="first">
				<div class="myform form" style="max-width:none;">
					<div class="logo mb-3">
						<div class="col-md-12 text-center">
							<h1>Vous pouvez écrire un message içi</h1>
						</div>
					</div>
					<form action="" method="post">
						<div class="form-group">
							<textarea name="message" class="form-control" rows="5" cols="50"></textarea>
						</div>
						<div class="col-md-12 text-center ">
							<button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Envoyer</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-12">
		<h1>Liste des messages</h1>
			<table id="messages" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Utilisateur</th>
						<th>Message</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$message_records item=message}
						<tr>
							<td>{$message.user}<br>{$message.date}</td>
							<td>{$message.message}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-4 mx-auto">
		<table id="users" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Utilisateur(s) connecté(s)</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$user_records item=user}
					{if $user.id neq $session.user_id}
						<tr>
							<td>{$user.name}</td>
						</tr>
					{/if}
				{/foreach}
			</tbody>
		</table>
	</div>
</div>

{include file="../_bot.tpl"}