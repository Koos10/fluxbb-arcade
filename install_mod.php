<?php
/***********************************************************************/

// Some info about your mod.
$mod_title      = 'FluxBB Arcade Mod';
$mod_version    = '1.2.0';
$release_date   = '2014-01-09';
$author         = 'Koos (original PunBB 1.2 version by ANGO, Dharmil and Pandark)';
$author_email   = 'pampoen10@yahoo.com';

// Versions of FluxBB this mod was created for. A warning will be displayed, if versions do not match
$fluxbb_versions= array('1.4.8', '1.4.9', '1.4.10', '1.4.11', '1.5.0', '1.5.1', '1.5.2', '1.5.3', '1.5.4', '1.5.5', '1.5.6');

// Set this to false if you haven't implemented the restore function (see below)
$mod_restore	= true;


// This following function will be called when the user presses the "Install" button
function install()
{
	global $db, $db_type, $pun_config;

	//New Install
	if (!$db->table_exists('arcade_ranking'))
	{
		$schema = array(
			'FIELDS'		=> array(
				'rank_id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'rank_game'		=> array(
					'datatype'		=> 'VARCHAR(50)',
					'allow_null'	=> false,
					'default'		=> '\'0\''
				),
				'rank_player'		=> array(
					'datatype'		=> 'SMALLINT(5)',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'rank_score'		=> array(
					'datatype'		=> 'DOUBLE',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'rank_topscore'		=> array(
					'datatype'		=> 'TINYINT(1)',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'rank_date'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> true,
				)
			),
			'PRIMARY KEY'	=> array('rank_id'),
		);

		$db->create_table('arcade_ranking', $schema) or error('Unable to create table '.$db->prefix.'arcade_ranking.', __FILE__, __LINE__, $db->error());
	}


	if (!$db->table_exists('arcade_games'))
	{
		$schema = array(
			'FIELDS'		=> array(
				'game_id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'game_name'		=> array(
					'datatype'		=> 'VARCHAR(50)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'game_filename'		=> array(
					'datatype'		=> 'VARCHAR(30)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'game_desc'		=> array(
					'datatype'		=> 'TEXT',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'game_image'		=> array(
					'datatype'		=> 'VARCHAR(200)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'game_width'		=> array(
					'datatype'		=> 'SMALLINT(5)',
					'allow_null'	=> false,
					'default'		=> '550'
				),
				'game_height'		=> array(
					'datatype'		=> 'SMALLINT(5)',
					'allow_null'	=> false,
					'default'		=> '400'
				),
				'game_cat'		=> array(
					'datatype'		=> 'SMALLINT(5)',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'game_played'		=> array(
					'datatype'		=> 'SMALLINT(5)',
					'allow_null'	=> false,
					'default'		=> '0'
				)
			),
			'PRIMARY KEY'	=> array('game_id'),
		);

		$db->create_table('arcade_games', $schema) or error('Unable to create table '.$db->prefix.'arcade_games.', __FILE__, __LINE__, $db->error());
	}


	// Add config options
	$config = array(
		'arcade_showtop'						=> "'1'",
		'arcade_numchamps'					=> "'5'",
		'arcade_live'				=> "'1'",
		'arcade_numnew'				=> "'10'",
		'arcade_mostplayed'			=> "'6'"
	);

	foreach ($config as $conf_name => $conf_value)
	{
		// Insert new config option if it doesn't exist
		$result = $db->query('SELECT 1 FROM '.$db->prefix.'config WHERE conf_name = \''.$conf_name.'\'');
		if (!$db->num_rows($result))
			$db->query('INSERT INTO '.$db->prefix.'config (conf_name, conf_value) VALUES(\''.$conf_name.'\', '.$conf_value.')') or error('Unable to insert config value \''.$conf_name.'\'', __FILE__, __LINE__, $db->error());
	}


	// Add games

	// English game descriptions 
	$games = array(
		//game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat
		array("Balloon Hunter", "balloonhunter", "Shoot down the balloons before they leave your reach.<br />Accuracy, timing and power are everything in this game.", "balloonhunter.jpg", 550, 400, 9),
		array("Breakit", "breakit", "Use YOUR MOUSE to move the base, hit the ball against the brick wall to breakthrough and proceed onto the next level.<br />Be sure to collect the points and power ups. Avoid power downs! There are 50 unique stages to play.", "breakit.jpg", 640, 480, 4),
		array("Diamond Mines", "diamondmine", "The screen is full of gems and you must move the checks around to create three of the same kind of gem in a row.", "diamondmine.jpg", 550, 400, 3),
		array("Tetrollapse", "tetrollapse", "You should not only escape the over-filling of the board but also sort out the figures which are on the board.<br />If the figure disappears you will pass to the next level where another figure is preparing for you.", "tetrollapse.jpg", 640, 480, 3),
		array("Frogger", "frogger", "The object of this game is to guide a frog to its home.<br />To do so, the player must get frogs to successfully dodge cars and navigate a river full of hazards.", "frogger.jpg", 400, 450, 1),
		array("Space Invaders", "invaders", "Taito had the inspired idea around 1978 that killing aliens was extremely good fun.<br />So they invented a game called Space Invaders.", "invaders.jpg", 520, 440, 1),
		array("Reel Gold", "reelgold", "Move your cart around on the rails and fire the rope down to reel in gold but avoid hitting rocks.", "reelgold.jpg", 550, 450, 4),
		array("Spank The Monkey", "spankmonkey", "Spank the monkey as hard as you can.", "spankmonkey.jpg", 850, 400, 4),
		array("Speartoss Wheelchair", "speartoss", "How far can you throw the spear?", "speartoss.jpg", 625, 360, 9),
		array("Speartoss 5 Shots", "speartoss5shots", "How far can you throw the spear?", "speartoss5shots.jpg", 625, 360, 9),
	);

	foreach ($games as $value)
	{
		// Insert new game if it doesn't exist
		$result = $db->query('SELECT 1 FROM '.$db->prefix.'arcade_games WHERE game_name = \''.$value[0].'\'');
		if (!$db->num_rows($result))
			$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES (\''.$value[0].'\', \''.$value[1].'\', \''.$value[2].'\', \''.$value[3].'\', \''.$value[4].'\', \''.$value[5].'\', \''.$value[6].'\')') or error('Unable to add game '.$value[0], __FILE__, __LINE__, $db->error());
	}


	// Regenerate the config cache
	if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
		require PUN_ROOT.'include/cache.php';

	generate_config_cache();
}

// This following function will be called when the user presses the "Restore" button (only if $mod_restore is true (see above))
function restore()
{
	global $db, $db_type, $pun_config;

	$db->drop_table('arcade_ranking') or error('Unable to remove table '.$db->prefix.'arcade_ranking.', __FILE__, __LINE__, $db->error());
	$db->drop_table('arcade_games') or error('Unable to remove table '.$db->prefix.'arcade_games.', __FILE__, __LINE__, $db->error());

	// Delete arcade config options
	$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_showtop"') or error('Unable to delete "arcade_showtop" from config table', __FILE__, __LINE__, $db->error());
	$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_numchamps"') or error('Unable to delete "arcade_numchamps" from config table', __FILE__, __LINE__, $db->error());
	$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_live"') or error('Unable to delete "arcade_live" from config table', __FILE__, __LINE__, $db->error());
	$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_numnew"') or error('Unable to delete "arcade_numnew" from config table', __FILE__, __LINE__, $db->error());
	$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_mostplayed"') or error('Unable to delete "arcade_mostplayed" from config table', __FILE__, __LINE__, $db->error());	

	// Regenerate the config cache
	if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
		require PUN_ROOT.'include/cache.php';

	generate_config_cache();
}

/***********************************************************************/

// DO NOT EDIT ANYTHING BELOW THIS LINE!


// Circumvent maintenance mode
define('PUN_TURN_OFF_MAINT', 1);
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

// We want the complete error message if the script fails
if (!defined('PUN_DEBUG'))
	define('PUN_DEBUG', 1);

// Make sure we are running a FluxBB version that this mod works with
$version_warning = !in_array($pun_config['o_cur_version'], $fluxbb_versions);

$style = (isset($pun_user)) ? $pun_user['style'] : $pun_config['o_default_style'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo pun_htmlspecialchars($mod_title) ?> installation</title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $style.'.css' ?>" />
</head>
<body>

<div id="punwrap">
<div id="puninstall" class="pun" style="margin: 10% 20% auto 20%">

<?php

if (isset($_POST['form_sent']))
{
	if (isset($_POST['install']))
	{
		// Run the install function (defined above)
		install();

?>
<div class="block">
	<h2><span>Installation successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>Your database has been successfully prepared for <?php echo pun_htmlspecialchars($mod_title) ?>. See readme.txt for further instructions.</p>
		</div>
	</div>
</div>
<?php

	}
	else
	{
		// Run the restore function (defined above)
		restore();

?>
<div class="block">
	<h2><span>Restore successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>Your database has been successfully restored.</p>
		</div>
	</div>
</div>
<?php

	}
}
else
{

?>
<div class="blockform">
	<h2><span>Mod installation</span></h2>
	<div class="box">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?foo=bar">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<p>This script will update your database to work with the following modification:</p>
				<p><strong>Mod title:</strong> <?php echo pun_htmlspecialchars($mod_title.' '.$mod_version) ?></p>
				<p><strong>Author:</strong> <?php echo pun_htmlspecialchars($author) ?> (<a href="mailto:<?php echo pun_htmlspecialchars($author_email) ?>"><?php echo pun_htmlspecialchars($author_email) ?></a>)</p>
				<p><strong>Disclaimer:</strong> Mods are not officially supported by FluxBB. Mods generally can't be uninstalled without running SQL queries manually against the database. Make backups of all data you deem necessary before installing.</p>
<?php if ($mod_restore): ?>
				<p>If you've previously installed this mod and would like to uninstall it, you can click the Restore button below to restore the database.</p>
<?php endif; ?>
<?php if ($version_warning): ?>
				<p style="color: #a00"><strong>Warning:</strong> The mod you are about to install was not made specifically to support your current version of FluxBB (<?php echo $pun_config['o_cur_version']; ?>). This mod supports FluxBB versions: <?php echo pun_htmlspecialchars(implode(', ', $fluxbb_versions)); ?>. If you are uncertain about installing the mod due to this potential version conflict, contact the mod author.</p>
<?php endif; ?>
			</div>
			<p class="buttons"><input type="submit" name="install" value="Install" /><?php if ($mod_restore): ?><input type="submit" name="restore" value="Restore" /><?php endif; ?></p>
		</form>
	</div>
</div>
<?php

}

?>

</div>
</div>

</body>
</html>
<?php

// End the transaction
$db->end_transaction();

// Close the db connection (and free up any result data)
$db->close();
