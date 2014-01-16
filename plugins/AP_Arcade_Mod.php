<?php

// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define('PUN_PLUGIN_LOADED', 1);

//===========================================================================//
//= Start the script code =//

$action = isset($_GET['action']) ? $_GET['action'] : NULL;
$id = isset($_GET['id']) ? intval($_GET['id']) : NULL;


//===========================================================================//
//= Add game =//
if($action == 'add')
{
	//if your saving the game
	if(isset($_POST['form_sent']))
	{
		// Check to see if the shortname, name and description were sent
		if(empty($_POST['name']))
			message('You need to enter a name for your game');
		if(empty($_POST['filename']))
			message('You need to enter a filename');
		if(empty($_POST['width']))
			message('You need to enter a width for your game');
		if(empty($_POST['description']))
			message('You need to enter description for your game');
		if(empty($_POST['height']))
			message('You need to enter a height for your game');
		if(empty($_POST['image']))
			message('You need to enter image for your game');
		if(empty($_POST['category']))
			message('You need to enter a category for your game');

		// Clean up filename, name and description from POST
		$name = pun_trim($_POST['name']);
		$filename = pun_trim($_POST['filename']);
		$description = pun_linebreaks($db->escape($_POST['description']));
		$width = pun_trim($_POST['width']);
		$height = pun_trim($_POST['height']);
		$image = pun_trim($_POST['image']);
		$category = pun_trim($_POST['category']);
		
		//insert the game in the database
		$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES("'.$name.'", "'.$filename.'", "'.$description.'", "'.$image.'", "'.$width.'", "'.$height.'", "'.$category.'")') or error('Unable to Add game', __FILE__, __LINE__, $db->error());
		
		//Find the new game_id and redirect to the added game
	$result = $db->query("SELECT game_id, game_name FROM ".$db_prefix."arcade_games WHERE game_name='".$name."'") or error('Unable to fetch game information', __FILE__, __LINE__, $db->error());
	$new_id = $db->fetch_assoc($result);
	redirect('arcade_play.php?id='.$new_id['game_id'], 'Game sucessfully added, redirecting &hellip;');
	
	}

	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="blockform">
		<h2><span>Add game</span></h2>
		<div class="box">
			<form id="example" method="post" action="admin_loader.php?plugin=<?php echo $plugin ?>&amp;action=<?php echo $action ?>">
				<input type="hidden" name="form_sent" value="TRUE" />
				<div class="inform">
					<fieldset>
						<legend>Enter game settings and description</legend>
						<div class="infldset">
							<table class="aligntop" cellspacing="0">
								<tr>
									<td><strong>Name:</strong> <br/> <input type="text" name="name" size="30" tabindex="1" />
									<span>The name of the game. Example: <i>Space Invaders</i></span></td>
								</tr>
								<tr>
									<td><strong>Filename:</strong> <br/> <input type="text" name="filename" size="30" tabindex="1" /> .swf<span>The filename of the game without the extension .swf. Example: <i>Invaders</i></span></td></td>
								</tr>
								<tr>
									<td><strong>Description:</strong><br/><textarea name="description" tabindex="1" rows="8" cols="50" style="width:100%"></textarea><span>Enter a short description of the game. This text may contain HTML.</span></td></td>
								</tr>
									<td><strong>Image:</strong><br/> <input type="text" name="image" size="30" tabindex="1" /><span>The name of the thumb image. Example: <i>invaders.jpg</i> or <i>invaders.gif</i></span></td>
								</tr>
								<tr>
									<td><strong>Width:</strong><br/> <input type="text" name="width" size="30" tabindex="1" /><br /><br/><strong>Height:</strong><br/> <input type="text" name="height" size="30" tabindex="1" /><br/><span>The dimensions of the game.</span></td>
								</tr>
								<tr>
									<td><strong>Category:</strong><br/> <input type="text" name="category" size="30" tabindex="1" /><span>Enter a game category for this game. <p>(1 = Arcade, 2 = Shooting, 3 = Puzzle, 4 = Skill, 5 = Card, 6 = Adventure, 7 = JumpAndRun, 8 = Racing, 9 = Sport)</span></td>
								</tr>								
							</table>
						</div>
					</fieldset>
				</div>
				<p><input type="submit" name="submit" value="Submit" tabindex="3" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
			</form>
		</div>
	</div>
<?php
}

//===========================================================================//
//= Edit Action game =//
elseif($action == 'edit')
{
	//if your saving the game
	if(isset($_POST['form_sent']))
	{
		if(empty($_POST['id']))
			message('You need to enter a id for your game');
		if(empty($_POST['name']))
			message('You need to enter a name for your game');
		if(empty($_POST['filename']))
			message('You need to enter a filename for your game');
		if(empty($_POST['description']))
			message('You need to enter description for your game');
		if(empty($_POST['image']))
			message('You need to enter image extension for your game');
		if(empty($_POST['width']))
			message('You need to enter a width for your game');
		if(empty($_POST['height']))
			message('You need to enter a height for your game');

		// Clean up
		$id = pun_trim($_POST['id']);
		$name = pun_trim($_POST['name']);
		$filename = pun_trim($_POST['filename']);
		$description = pun_linebreaks($db->escape($_POST['description']));
		$image = pun_trim($_POST['image']);
		$width = pun_trim($_POST['width']);
		$height = pun_trim($_POST['height']);
		$category = pun_trim($_POST['category']);
		
		$db->query('UPDATE '.$db->prefix.'arcade_games SET game_name="'.$name.'", game_filename="'.$filename.'", game_desc="'.$description.'", game_id="'.$id.'",  game_image="'.$image.'", game_width="'.$width.'", game_height="'.$height.'", game_cat="'.$category.'" WHERE game_id="'.$id.'"') or error('Unable to update game', __FILE__, __LINE__, $db->error());
				
		redirect('admin_loader.php?plugin='.$plugin, 'Game sucessfully edited, redirecting &hellip;');
	}

	//pull out game info
	$result = $db->query("SELECT game_id, game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat  FROM ".$db_prefix."arcade_games WHERE game_id='".$id."'") or error('Unable to fetch game information', __FILE__, __LINE__, $db->error());
	if (!$db->num_rows($result))
		message($lang_common['Bad request']);

	$data = $db->fetch_assoc($result);

	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="blockform">
		<h2><span>Edit Game</span></h2>
		<div class="box">
			<form id="example" method="post" action="admin_loader.php?plugin=<?php echo $plugin ?>&amp;action=<?php echo $action ?>&amp;id=<?php echo $id ?>">
				<input type="hidden" name="form_sent" value="TRUE" />
				<input type="hidden" name="shortname" value="<?php echo $data['id']?>" size="50" tabindex="1" />
				<div class="inform">
					<fieldset>
						<legend>Enter game settings and description</legend>
						<div class="infldset">
							<table class="aligntop" cellspacing="0">
								<tr>
									<td><strong>Id</strong> <br/> <input type="text" name="id" value="<?php echo $data['game_id']?>" size="30" tabindex="1" /></td>
								</tr>
								<tr>
									<td><strong>Name</strong> <br/> <input type="text" name="name" value="<?php echo $data['game_name']?>" size="30" tabindex="1" /></td>
								</tr>
								<tr>
									<td><strong>Filename</strong> <br/> <input type="text" name="filename" value="<?php echo $data['game_filename']?>" size="30" tabindex="1" /> .swf</td>
								</tr>
								<tr>
									<td><strong>Description</strong> <br/><textarea name="description" tabindex="1" rows="8" cols="50" style="width:100%"><?php echo pun_htmlspecialchars($data['game_desc'])?></textarea></td>
								</tr>
								<tr>
									<td><strong>Image</strong> <br/> <input type="text" name="image" value="<?php echo $data['game_image']?>" size="30" tabindex="1" /></td>
								</tr>
								<tr>
									<td><strong>Width</strong> <br/> <input type="text" name="width" value="<?php echo $data['game_width']?>" size="30" tabindex="1" /></td>
								</tr>
								<tr>
									<td><strong>Height</strong> <br/> <input type="text" name="height" value="<?php echo $data['game_height']?>" size="30" tabindex="1" /></td>
								</tr>
								<tr>
									<td><strong>Category:</strong><br/> <input type="text" name="category" value="<?php echo $data['game_cat']?>" size="30" tabindex="1" /><span>(1 = Arcade, 2 = Shooting, 3 = Puzzle, 4 = Skill, 5 = Card, 6 = Adventure, 7 = JumpAndRun, 8 = Racing, 9 = Sport)</span></td>
								</tr>								
							</table>
						</div>
					</fieldset>
				</div>
				<p><input type="submit" name="submit" value="Submit" tabindex="3" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
			</form>
		</div>
	</div>
<?php
}
//===========================================================================//
//= Delete Action game =//
elseif($action == 'delete')
{
	if(isset($_POST['delete_comply']))
	{
		//There isnt anything to do but delete the game and redirect
		$db->query('DELETE FROM '.$db->prefix.'arcade_games WHERE game_id="'.$id.'"') or error('Unable to delete game', __FILE__, __LINE__, $db->error());
		
		redirect('admin_loader.php?plugin='.$plugin, 'Game sucessfully deleted, redirecting &hellip;');
	}
		
	//Display the admin navigation menu
	generate_admin_menu($plugin);
?>
	<div class="blockform">
		<h2><span>Delete Game</span></h2>
		<div class="box">
			<form id="example" method="post" action="admin_loader.php?plugin=<?php echo $plugin ?>&amp;action=<?php echo $action?>&amp;id=<?php echo $id ?>">
				<div class="inform">
					<fieldset>
						<legend>Important: read before deleting</legend>
						<div class="infldset">
						<p><strong>Warning!</strong><br/><br/>Deleted Games cannot be restored.</p>
						<p>Please confirm that you want to delete this game from the database.</p>
						</div>
					</fieldset>
				</div>
				<p><input type="submit" name="delete_comply" value="Delete" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
			</form>
		</div>
	</div>

<?php
}

//===========================================================================//
//= Listgames Action =//
elseif($action == 'listgames')
{
	//Display the admin navigation menu
	generate_admin_menu($plugin);
?>
	<div class="blockform">
		<h2><span>PunArcade Games</span></h2>
		<div class="box">
			<div class="fakeform">
				<div class="inform">
					<fieldset>
					<legend>Existing games</legend>
						<div class="infldset">
							<table cellspacing="0">
<?php
	//get all games info from the DB
	$result = $db->query('SELECT game_name, game_id FROM '.$db->prefix.'arcade_games ORDER BY game_id ASC') or error('Unable to select games from database', __FILE__, __LINE__, $db->error());
	if ($db->num_rows($result))
	{
		while($data = $db->fetch_assoc($result))
			echo "\t\t\t\t\t\t\t".'<tr>'."\n\t\t\t\t\t\t\t\t".'<th scope="row">'."\n\t\t\t\t\t\t\t\t\t".'<a href="admin_loader.php?plugin='.$plugin.'&amp;action=delete&amp;id='.$data['game_id'].'">Delete</a> | '."\n\t\t\t\t\t\t\t\t\t".'<a href="admin_loader.php?plugin='.$plugin.'&amp;action=edit&amp;id='.$data['game_id'].'">Edit</a>'."\n\t\t\t\t\t\t\t\t".'</th>'."\n\t\t\t\t\t\t\t\t".'<td><a href="arcade_play.php?id='.$data['game_id'].'">'.$data['game_name'].'</a>&nbsp;&nbsp;</td>'."\n\t\t\t\t\t\t\t".'</tr>'."\n";
	}
	else
		echo "\t\t\t\t\t\t\t".'<tr>'."\n\t\t\t\t\t\t\t\t".'<th scope="row">There are no games in the database</td>'."\n\t\t\t\t\t\t\t".'</tr>'."\n";
?>
							</table>
						</div>
					</fieldset>
				</div><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a>
			</div>
		</div>
	</div>

<?php	
}

//===========================================================================//
//= General Config =//
else
{
	//if saving config
	if(isset($_POST['form_sent']))
	{
		// Check for empty post
		if(empty($_POST['arcade_numchamps']))
			message('You need to enter the number of champions displayed');

		// Clean up
		$arcade_sort = pun_trim($_POST['arcade_sort']);
		$arcade_showtop = pun_trim(intval($_POST['arcade_showtop']));
		$arcade_numgames = pun_trim(intval($_POST['arcade_numgames']));
		$arcade_numchamps = pun_trim(intval($_POST['arcade_numchamps']));
		$arcade_live = pun_trim(intval($_POST['arcade_live']));
		$arcade_numnew = pun_trim(intval($_POST['arcade_numnew']));
		$arcade_mostplayed = pun_trim(intval($_POST['arcade_mostplayed']));
						
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$arcade_showtop.' WHERE conf_name="arcade_showtop" LIMIT 1') or error('Unable to update arcade_showtop in config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$arcade_numchamps.' WHERE conf_name="arcade_numchamps" LIMIT 1') or error('Unable to update arcade_numchamps in config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$arcade_live.' WHERE conf_name="arcade_live" LIMIT 1') or error('Unable to update permissions in config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$arcade_numnew.' WHERE conf_name="arcade_numnew" LIMIT 1') or error('Unable to update permissions in config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$arcade_mostplayed.' WHERE conf_name="arcade_mostplayed" LIMIT 1') or error('Unable to update permissions in config', __FILE__, __LINE__, $db->error());
		
		// Regenerate the config cache
		require_once PUN_ROOT.'include/cache.php';
		generate_config_cache();

		redirect('admin_loader.php?plugin='.$plugin.'','Config sucessfully updated, redirecting &hellip;');
	}

	// Display the admin navigation menu
	generate_admin_menu($plugin);

	// If the file include/cache.php wasn't already included, include it now
	if (!function_exists('generate_config_cache')) 
		require PUN_ROOT.'include/cache.php';

?>
	<div class="blockform">
		<h2><span>Arcade Mod Config</span></h2>
		<div class="box">
			<form id="example" method="post" action="admin_loader.php?plugin=<?php echo $plugin ?>">
				<input type="hidden" name="form_sent" value="TRUE" />
				<div class="inform">
					<fieldset>
						<legend>Index Page Settings</legend>
						<div class="infldset">
							<table class="aligntop" cellspacing="0">
								<tr>
								<td><strong>Enable Arcade</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="arcade_live" value="1"<?php if ($pun_config['arcade_live'] == '1') { echo ' checked'; } ?> />&nbsp;Yes&nbsp;
								<input type="radio" name="arcade_live" value="0"<?php if ($pun_config['arcade_live'] == '0') { echo ' checked'; } ?> />&nbsp;No
								</td>
								</tr>
								<tr>
									<td><strong>Display Statistic</strong>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="arcade_showtop" value="1"<?php if ($pun_config['arcade_showtop'] == '1') echo ' checked="checked"'?> />&nbsp;Yes&nbsp;&nbsp;<input type="radio" name="arcade_showtop" value="0"<?php if ($pun_config['arcade_showtop'] == '0') echo ' checked="checked"'; ?> />&nbsp;No<br /></td>
								</tr>
								<tr>
									<td><strong>Champions:</strong> <br/> <input type="text" name="arcade_numchamps" value="<?php echo $pun_config['arcade_numchamps']?>" size="20" tabindex="1" />
								<br /><span>Number of new champions</span>
									</td>
								</tr>
								<tr>
									<td><strong>New Games:</strong> <br/> <input type="text" name="arcade_numnew" value="<?php echo $pun_config['arcade_numnew']?>" size="20" tabindex="1" />
								<br /><span>Number of new games</span>
									</td>
								</tr>
								<tr>
									<td><strong>Most played:</strong> <br/> <input type="text" name="arcade_mostplayed" value="<?php echo $pun_config['arcade_mostplayed']?>" size="20" tabindex="1" />
								<br /><span>Number of most played games</span>
									</td>
								</tr>
							</table>
						</div>
						<p><input type="submit" name="submit" value="Submit" tabindex="1" /></p><br />
					</fieldset>
				</div>
		<fieldset>
		<legend>Game Settings</legend>
			<div class="infldset">
				<table class="aligntop" cellspacing="0">
					<tr>
						<td>
							<p><a href="admin_loader.php?plugin=<?php echo $plugin ?>&amp;action=listgames">List Games</a></p>
						</td>
					</tr>
					<tr>
						<td>
							<p><a href="admin_loader.php?plugin=<?php echo $plugin ?>&amp;action=add">Add New Game</a></p>
						</td>
					</tr>
				</table>
			</div>
		</fieldset>

			</form>
		</div>
	</div>

<?php
}

// Note that the script just ends here. The footer will be included by admin_loader.php.
