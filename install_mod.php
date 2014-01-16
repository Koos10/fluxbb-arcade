<?php
/***********************************************************************/

// Some info about your mod.
$mod_title      = 'PunBB_Arcade_Games';
$mod_version    = '1.2.0';
$release_date   = '2013-04-16';
$author         = 'ANGO, Dharmil, Pandark';
$author_email   = ' ';


// Set this to false if you haven't implemented the restore function (see below)
$mod_restore	= true;


// This following function will be called when the user presses the "Install" button
function install()
{
	global $db, $db_type, $pun_config;

	//New Install
	if ($db_type == 'mysql' || $db_type == 'mysqli')
	{
		$db->query("CREATE TABLE ".$db->prefix."arcade_ranking (
				`rank_id` SMALLINT(5) NOT NULL auto_increment,
				`rank_game` varchar(50) NOT NULL default '0',
				`rank_player` SMALLINT(5) NOT NULL default '0',
				`rank_score` double NOT NULL default '0',
				`rank_topscore` TINYINT(1) NOT NULL default '0',
				`rank_date` INTEGER UNSIGNED default NULL,
				PRIMARY KEY  (`rank_id`)
				) TYPE=MyISAM;") or error('Unable to add table "arcade_ranking" ', __FILE__, __LINE__, $db->error());

		$db->query("CREATE TABLE ".$db->prefix."arcade_games (
				`game_id` SMALLINT(5) NOT NULL auto_increment,
				`game_name` varchar(50) NOT NULL default '',
				`game_filename` varchar(30) NOT NULL default '',
				`game_desc` text NOT NULL,
				`game_image` varchar(200) NOT NULL default '',
				`game_width` smallint(5) NOT NULL default '550',
				`game_height` smallint(5) NOT NULL default '400',
				`game_cat` smallint(5) NOT NULL default '0',
				`game_played` smallint(5) NOT NULL default '0',
				PRIMARY KEY  (`game_id`)
				) TYPE=MyISAM AUTO_INCREMENT=6;") or error('Unable to add table "arcade_games" ', __FILE__, __LINE__, $db->error());

		// Config
		$db->query('INSERT INTO '.$db->prefix.'config VALUES ("arcade_showtop", "1")') or error('Unable to add "arcade_showtop" in config table', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'config VALUES ("arcade_numchamps", "5")') or error('Unable to add "arcade_numchamps" in config table', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'config VALUES ("arcade_live", "1")') or error('Unable to add arcade_live" in config table', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'config VALUES ("arcade_numnew", "10")') or error('Unable to add arcade_numnew" in config table', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'config VALUES ("arcade_mostplayed", "6")') or error('Unable to add arcade_mostplayed" in config table', __FILE__, __LINE__, $db->error());

		// Add games
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Balloon Hunter", "balloonhunter", "Shoot down the balloons before they leave your reach.<br />Accuracy, timing and power are everything in this game.", "balloonhunter.jpg", 550, 400, 9)') or error('Unable to add game Balloon Hunter', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Breakit", "breakit", "Use YOUR MOUSE to move the base, hit the ball against the brick wall to breakthrough and proceed onto the next level.<br />Be sure to collect the points and power ups. Avoid power downs! There are 50 unique stages to play.", "breakit.jpg", 640, 480, 4)') or error('Unable to add game Breakit', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Diamond Mines", "diamondmine", "The screen is full of gems and you must move the checks around to create three of the same kind of gem in a row.", "diamondmine.jpg", 550, 400, 3)') or error('Unable to add game Diamond Mines', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Tetrollapse", "tetrollapse", "You should not only escape the over-filling of the board but also sort out the figures which are on the board.<br />If the figure disappears you will pass to the next level where another figure is preparing for you.", "tetrollapse.jpg", 640, 480, 3)') or error('Unable to add game Tetrollapse', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Frogger", "frogger", "The object of this game is to guide a frog to its home.<br />To do so, the player must get frogs to successfully dodge cars and navigate a river full of hazards.", "frogger.jpg", 400, 450, 1)') or error('Unable to add game Frogger', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Space Invaders", "invaders", "Taito had the inspired idea around 1978 that killing aliens was extremely good fun.<br />So they invented a game called Space Invaders.", "invaders.jpg", 520, 440, 1)') or error('Unable to add game Space Invaders', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Reel Gold", "reelgold", "Move your cart around on the rails and fire the rope down to reel in gold but avoid hitting rocks.", "reelgold.jpg", 550, 450, 4)') or error('Unable to add game Reel Gold', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Spank The Monkey", "spankmonkey", "Spank the monkey as hard as you can.", "spankmonkey.jpg", 850, 400, 4)') or error('Unable to add game Spank The Monkey', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Speartoss Wheelchair", "speartoss", "How far can you throw the spear?", "speartoss.jpg", 625, 360, 9)') or error('Unable to add game Wheelchair Speartoss', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Speartoss 5 Shots", "speartoss5shots", "How far can you throw the spear?", "speartoss5shots.jpg", 625, 360, 9)') or error('Unable to add game Speartoss 5 Shots', __FILE__, __LINE__, $db->error());
	}
	else
		exit('This mod currently only supports MySQL and MySQLi.');

	// Delete everything in the cache since we messed with some stuff
	$d = dir(PUN_ROOT.'cache');
	while (($entry = $d->read()) !== false)
	{
		if (substr($entry, strlen($entry)-4) == '.php')
			@unlink(PUN_ROOT.'cache/'.$entry);
	}
	$d->close();
}

// This following function will be called when the user presses the "Restore" button (only if $mod_uninstall is true (see above))
function restore()
{
	global $db, $db_type, $pun_config;

	if ($db_type == 'mysql' || $db_type == 'mysqli')
	{
		$db->query('DROP TABLE '.$db->prefix.'arcade_ranking') or error('Unable to drop table "arcade_ranking"', __FILE__, __LINE__, $db->error());
		$db->query('DROP TABLE '.$db->prefix.'arcade_games') or error('Unable to drop table "arcade_games"', __FILE__, __LINE__, $db->error());
		$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_showtop"') or error('Unable to delete "arcade_showtop" from config table', __FILE__, __LINE__, $db->error());
		$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_live"') or error('Unable to delete "arcade_live" from config table', __FILE__, __LINE__, $db->error());
		$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_numnew"') or error('Unable to delete "arcade_numnew" from config table', __FILE__, __LINE__, $db->error());
		$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_numchamps"') or error('Unable to delete "arcade_numchamps" from config table', __FILE__, __LINE__, $db->error());
		$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name="arcade_mostplayed"') or error('Unable to delete "arcade_mostplayed" from config table', __FILE__, __LINE__, $db->error());	
	}
	else
		exit('This mod currently only supports MySQL and MySQLi.');

	// Delete everything in the cache since we messed with some stuff
	$d = dir(PUN_ROOT.'cache');
	while (($entry = $d->read()) !== false)
	{
		if (substr($entry, strlen($entry)-4) == '.php')
			@unlink(PUN_ROOT.'cache/'.$entry);
	}
	$d->close();
}

/***********************************************************************/

// DO NOT EDIT ANYTHING BELOW THIS LINE!


// Circumvent maintenance mode
define('PUN_TURN_OFF_MAINT', 1);
define('PUN_ROOT', './');

@include PUN_ROOT.'config.php';

// If PUN isn't defined, config.php is missing or corrupt
if (!defined('PUN'))
	exit('The file \'config.php\' doesn\'t exist or is corrupt. Please run install.php to install PunBB first.');

// Load the functions script
require PUN_ROOT.'include/functions.php';

// Load DB abstraction layer and try to connect
require PUN_ROOT.'include/dblayer/common_db.php';

// Load cached config
@include PUN_ROOT.'cache/cache_config.php';
if (!defined('PUN_CONFIG_LOADED'))
{
    require PUN_ROOT.'include/cache.php';
    generate_config_cache();
    require PUN_ROOT.'cache/cache_config.php';
}


// We want the complete error message if the script fails
if (!defined('PUN_DEBUG'))
	define('PUN_DEBUG', 1);

$version = explode(".", $pun_config['o_cur_version']);
// Make sure we are running a PunBB version that this mod works with
if ($version[0] != 1 || $version[1] != 2)
	exit('You are running a version of PunBB ('.$pun_config['o_cur_version'].') that this mod does not support. This mod supports PunBB versions: 1.2.x');

$style = (isset($cur_user)) ? $cur_user['style'] : $pun_config['o_default_style'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $mod_title ?> installation</title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $pun_config['o_default_style'].'.css' ?>" />
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
				<p><strong>Mod title:</strong> <?php echo pun_htmlspecialchars($mod_title).' '.$mod_version ?></p>
				<p><strong>Author:</strong> <?php echo pun_htmlspecialchars($author) ?> (<a href="mailto:<?php echo pun_htmlspecialchars($author_email) ?>"><?php echo pun_htmlspecialchars($author_email) ?></a>)</p>
				<p><strong>Disclaimer:</strong> Mods are not officially supported by PunBB. Mods generally can't be uninstalled without running SQL queries manually against the database. Make backups of all data you deem necessary before installing.</p>
<?php if ($mod_restore): ?>				<p>If you've previously installed this mod and would like to uninstall it, you can click the restore button below to restore the database.</p>
<?php endif; ?>			</div>
			<p><input type="submit" name="install" value="Install" /><?php if ($mod_restore): ?><input type="submit" name="restore" value="Restore" /><?php endif; ?></p>
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