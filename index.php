<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meetic Trends</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

	<link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<header>
	<h1>Meetic Trends</h1>
</header>

<div id="wrapper">
<?php

$data = json_decode(file_get_contents('data.json'));

$questions = $data->questions;

$_GET['q'] = isset($_GET['q']) ? $_GET['q'] : 1;

$question = $questions[$_GET['q']-1];

if ( ! isset($_SESSION['score']) || isset($_GET['new'])):
	$_SESSION['score'] = array();
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

if ( isset($_GET['a']) ):
	if ( $_GET['a'] == $question->answer):
		$_SESSION['score'][$_GET['q']] = 1;
		?>
		<div class="good">
			<p>
				Yes, you selected the correct Selfie !
			</p>
			<figure>
				<img src="/assets/quiz<?php print $_GET['q'] ?>/<?php print $question->answer ?>.jpg">
			</figure>
		</div>
		<?php
		$nextText = "Another Selfie?";
	else:
		?>
		<div class="bad">
			<p>
				Ooops, the correct answer was :
			</p>
			<figure>
				<img src="/assets/quiz<?php print $_GET['q'] ?>/<?php print $question->answer ?>.jpg">
			</figure>
		</div>
		<?php
		$nextText = "Better luck next Selfie?";
	endif;
	?>
	<?php

	if ($questions[$_GET['q']]):
		?>
		<div class="navigation">
			<p>
				<a href="/?q=<?php print $_GET['q']+1 ?>"><?php print $nextText ?> On to question <?php print $_GET['q']+1 ?> / <?php print count($questions) ?></a>
			</p>
		</div>
		<?php
	else:
		for($i=1;$i<=count($questions);$i++)
			$s += $_SESSION['score'][$i];

		$resultText = "You can do better";
		if ( $_SESSION['score'] > count($questions) / 3 )
			$resultText = "Not Bad";
		if ( $_SESSION['score'] > count($questions) / 3 * 2 )
			$resultText = "Very Good";
		if ( $_SESSION['score'] == count($questions) )
			$resultText = "Bery Good";
		?>
		<div class="score">
			<p>
				That’s the end of the game ! 
				<br />
				You scored <?php print $s ?> out of <?php print count($questions) ?>  : <strong>	<?php print $resultText ?>   </strong>
			</p>
			<p>
				<a href="/?new">Try again !</a>
			</p>
			<p>
				See how will your friends score on Selfies which turned badly > Facebook
			</p>
		</div>
		<?php
	endif;
	?>
	<?php
else:
	if ( $question ):
		?>
		<h2><?php print $question->title ?></h2>
		<ul class="answers">
		<?php
		$items = array('1', '2', '3', '4');
		shuffle($items);
		foreach($items as $item):
			?>
			<li>
				<a href="/?q=<?php print $_GET['q'] ?>&a=<?php print $item ?>">
					<img src="/assets/quiz<?php print $_GET['q'] ?>/<?php print $item ?>.jpg" />
				</a>
			</li>
			<?php
		endforeach;
		?>
		</ul>
		<?php
	endif;
endif;

?>

</div>

<footer>
	
</footer>

<xmp>
<?php
// print_r($_SESSION);
/*
print_r(array(
	'_get'	=>	$_GET,
	'question'	=>	$question,
	'data' => $data
));
*/
?>
</xmp>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
