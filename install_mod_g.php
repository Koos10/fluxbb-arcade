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
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Balloon Hunter", "balloonhunter", "Du musst versuchen mit Pfeil und Bogen Luftballons vom Himmel schiessen.<br />Keine leichte Aufgabe, denn die Windstärke ändert sich von Zeit zu Zeit.", "balloonhunter.jpg", 550, 400, 9)') or error('Unable to add game Balloon Hunter', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Breakit", "breakit", "Der Spieler muss mit einem Paddel den Ball im Spiel halten und die Steine aus dem Spielfeld entfernen.<br />Breakit ist sehr gute Breakout Umsetzung und bietet sehr gute Grafik und viel Abwechslung.", "breakit.jpg", 640, 480, 4)') or error('Unable to add game Breakit', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Diamond Mines", "diamondmine", "Diamond Mine ist ein klassisches Spiel, in dem Sie Reihen aus drei oder vier identischen Steinen aufbauen müssen.", "diamondmine.jpg", 550, 400, 3)') or error('Unable to add game Diamond Mines', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Tetrollapse", "tetrollapse", "Bei dieser Tetris Variante muss man die vorhandenen Figuren beseitigen um ins nächste Level zu gelangen.<br />Ansonsten bleiben die Regeln wie gewohnt. Es gibt 33 verschiedene Level.", "tetrollapse.jpg", 640, 480, 3)') or error('Unable to add game Tetrollapse', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Frogger", "frogger", "Bringe den Frosch sicher über die stark befahrene Straße und über den Fluss.<br />Der Frosch muss dabei auf der Straße Autos ausweichen und zur Überquerung eines Flusses treibende Äste als Plattformen nutzen.", "frogger.jpg", 400, 450, 1)') or error('Unable to add game Frogger', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Space Invaders", "invaders", "Dies ist das originalgetreue Abbild des 1978 erschienen Kult- spiels Space Invaders!<br /> Eine Horde von Aliens wandert den Bildschirm herunter. Je mehr Aliens abgeschossen werden, desto schneller bewegen sie sich.", "invaders.jpg", 520, 440, 1)') or error('Unable to add game Space Invaders', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Reel Gold", "reelgold", "Ziel des Spiel Reel Gold ist es in jedem Level soviele Goldstücke wie möglich mit deiner Seilwinde ans Tageslicht zu befördern.<br />Es können nur glänzende Klumpen geborgen werden. Habt ihr beim Einholen Kontakt mit einem Stein verliert ihr den Goldklumpen.", "reelgold.jpg", 550, 450, 4)') or error('Unable to add game Reel Gold', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Spank The Monkey", "spankmonkey", "Der Spieler muss per Maus mit der virtuelle Hand so schnell und hart wie möglich auf den Affen einschlagen.", "spankmonkey.jpg", 850, 400, 4)') or error('Unable to add game Spank The Monkey', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Speartoss Wheelchair", "speartoss", "Wie weit kannst Du den Speer werfen?", "speartoss.jpg", 625, 360, 9)') or error('Unable to add game Wheelchair Speartoss', __FILE__, __LINE__, $db->error());
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("Speartoss 5 Shots", "speartoss5shots", "Du hast 5 Versuche um den Speer soweit wie möglich zu werfen. Alle Versuche werden dann am Ende addiert.", "speartoss5shots.jpg", 625, 360, 9)') or error('Unable to add game Speartoss 5 Shots', __FILE__, __LINE__, $db->error());
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