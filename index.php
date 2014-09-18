<?php

$data = json_decode(file_get_contents('data.json'));

$_GET['q'] = $_GET['q'] ? $_GET['q'] : 1;

$question = $data[$_GET['q']];


if ( isset($_GET['score']) || ! isset($_SESSION['score']) ):
	$_SESSION['score'] = 0;
endif;

if ( isset($_GET['score'])):
	?>
	<p>
		Ton score est <?php $_SESSION['score'] ?> / <?php print count($question)-1 ?>
	</p>
	<p>
		<a href="/?new"><Recommencer</a>
	</p>
	<?php
endif;

if ( $_GET['a'] ):
	if ( $_GET['a'] == $question['answer']):
		?>
		<div class="good">
			<figure>
				<img src="/assets/<?php print $_GET['q'] ?>/<?php print $question['answer'] ?>.jpg">
			</figure>
			<p>
				Bonne Réponse !
			</p>
		</div>
		<?php
	else:
		?>
		<div class="bad">
			<p>
				Oops, la bonne réponse est : 
			</p>
			<figure>
				<img src="/assets/<?php print $_GET['q'] ?>/<?php print $question['answer'] ?>.jpg">
			</figure>
		</div>
		<?php
		<?php
	endif;
	?>
	<?php
	if ($data[$_GET['q']+1]):
		?>
		<p>
			<a href="/?q=<?php print $_GET['q']+1 ?>">Question Suivante  <?php print $_GET['q']+1 ?> / <?php print count($data)-1 ?></a>
		</p>
		<?php
	else:
		?>
		<p>
			<a href="/?score">Voir mon score</a>
		</p>
		<?php
	endif;
	?>
	<?php
else:
	if ( $question] ):
		?>
		<ul>
		<?php
		for(i=0;i<4;i++):
			?>
			<li>
				<a href="/?q=<?php print $_GET['q'] ?>&a=<?php print $i ?>">
					<img src="/assets/<?php print $_GET['q'] ?>/<?php print $i ?>.jpg" />
				</a>
			</li>
			<?php
		endfor;
		?>
		</ul>
		<?php
	endif;
endif;

