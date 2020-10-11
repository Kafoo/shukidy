<div class="OW" id="alloGM">
	<h3>ALLO GM</h3>

	<?php if ($aventure->userIsGM): ?>

		<div class="alloGMChoices">	
			<?php foreach ($aventure->characters as $character): ?>
				<?php if ($character->name !== 'GM'): ?>

					<div class="alloGMChoice choice-gen button"
					@click="chooseUser(<?=$character->userID?>)"

					><?=$character->name?></div>

				<?php endif ?>

			<?php endforeach ?>
		</div>

	<?php endif ?>


	<div class="OWContent">


			<div class="alloGM-content">

				<div v-for="message in messages"
				class="alloGM-msg"
				:class="message.class"
				id="message.id" 
				v-tooltipmsg="message">
					{{message.content}}
				</div>



			</div>
			<form method="POST" onsubmit="return false">				
				<textarea class="alloGM-textArea" v-model="messageInput" @keydown.enter.prevent @keydown.enter=send()></textarea>
				<input type="submit" class="alloGM-submit button" @click="send()" value="">
			</form>			
			
	</div>
</div>