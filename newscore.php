<?php
define('PUN_ROOT', './');
	message($lang_common['No permission']);
// Recover the game name and the score

			// Update new highscore
			$sql = 'SELECT game_id FROM '.$db->prefix.'arcade_games WHERE game_filename = \''.$db->escape($game_name).'\'';
			echo '<script type="text/javascript">window.location=\'arcade_ranking.php?id='.$gameid['game_id'].'\'</script>';
		}
		else
		{
	else
	{
		// Is there a score?
	}
}
else
	message($lang_common['No permission']);
}
?>