##
##        Mod title:  FluxBB Arcade Mod
##
##      Mod version:  1.2.0
##  Works on FluxBB:  1.4.* and 1.5.*
##     Release date:  2014-01-09
##           Author:  Koos (pampoen10@yahoo.com)
##  Original Author:  ANGO
##
##      Description:  This mod add flash games to your FluxBB forum. It also has a high score system.                  
##
##   Affected files:  none
##
##       Affects DB:  New tables:
##                       'arcade_ranking'
##                       'arcade_games'
##                    New options in 'config' table:
##                       'arcade_showtop'
##                       'arcade_numchamps'
##                       'arcade_live'
##                       'arcade_numnew'
##                       'arcade_mostplayed'
##                       'arcade_allow_guests'
##
##            Notes:  This Mod Comes with 10 Pre-installed Games. Additional games come as extension.
##
##       Disclaimer:  "FluxBB Arcade Mod" is not officially supported by FluxBB.
##                    Installation of this modification is done at your
##                    own risk. Backup your forum database and any and all
##                    applicable files before proceeding.
##
##          License:  FluxBB Arcade Mod is free software; you can redistribute it
##                    and/or modify it under the terms of the GNU General
##                    Public License as published by the Free Software
##                    Foundation; either version 2 of the License, or
##                    (at your option) any later version.
##                    Each flash game are the property of their authors.
##
##     Contributors:  PANDARK, DHARMIL, NICO_SOMB 
##		      
##		     


#
#---------[ 1. UPLOAD ]---------------------------------------------------
#

Copy the following files to your Pun root directory:

arcade.php
arcade_play.php
arcade_ranking.php
newscore.php
/games
/lang
/plugins
install_mod.php     (with english game descriptions)
 or
install_mod_g.php   (with german game descriptions)

... it looks like this:

|-[fluxbb root]
|         |-[plugins]
|         |-[lang]
|         |-[games]
               |-[xxxxx.swf]
|         |-[arcade.php]
|         |-[arcade_play.php]
|         |-[arcade_ranking.php]
|         |-[newscore.php]
|         |-[install_mod.php]

#
#---------[ 2. RUN ]---------------------------------------------------
#

install_mod.php (or install_mod_g.php)

#
#---------[ 3. DELETE ]---------------------------------------------------
#

install_mod.php (or install_mod_g.php)

#
#----------------------------------------------------------------------------
#

Create a link to arcade.php in ADMIN MENU/OPTIONS/Additional menu items:

X = <a href="arcade.php">Arcade Games</a>

where X is the position at which the link should be inserted.


#
#----------------------------------------------------------------------------
#


 Info for adding your own games
---------------------------------

You can use a php script for adding your games. Please look into one of my 
game addons for more details of the php syntax.

Example:
$db->query('INSERT INTO '.$db->prefix.'arcade_games (game_name, game_filename, game_desc, game_image, game_width, game_height, game_cat) VALUES ("GAMENAME", "FILENAME", "GAMEINFO", "GAMEPIC.jpg", GAMEWIDTH, GAMEHEIGHT, GAMECATEGORY)') or error('Unable to add game GAMENAME', __FILE__, __LINE__, $db->error());

GAMENAME:     The name of the game (Ex.: Tetris Deluxe)
FILENAME:     The filename of the game without .swf (Ex.: tetris)
GAMEINFO:     Some infos about the game (Ex.: This game is good.)
GAMEPIC.jpg:  The name of the game pic with .jpg (Ex.: tetris.jpg)
GAMEWIDTH:    The pixel width of the game (Ex.: 500)
GAMEHEIGHT:   The pixel hight of the game (Ex.: 450)
GAMECATEGORY: The game category (Ex.: 4)
              1=Arcade, 2=Shooting, 3=Puzzle, 4=Skill, 5=Card, 6=Adventure, 7=JumpAndRun, 8=Racing, 9=Sport


All games must be placed into the "game" folder.
All game images must be placed into the "games/images" folder.

Image format of game pics
- size: 50x50, format: JPEG, name: like the .swf game name  (Ex.: tetris.jpg)

Image format of small game pics
- size: 15x15, format: JPEG, name: like the .swf game name with an "_" underscore in front of (Ex.: _tetris.jpg)


 The following var´s are used inside the flash games
-----------------------------------------------------
Actionscript example:

on (release)
{
    score = _root.score;
    game_name = "tetrisdeluxe";
    if (score > 0)
    {
        getURL("newscore.php", "_self", "POST");
    } 
}




Have fun ...


 Making this mod compatible with ibProArcade games
-----------------------------------------------------

Simply add the following code to the top of index.php:

if ($_GET['act'] == 'Arcade' && $_GET['do'] == 'newscore')
{
  include 'newscore.php';
  exit();
}
