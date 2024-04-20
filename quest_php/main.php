<?php
/**
 * WarGameを実行するスクリプトです。
 *
 * @category Script
 * @package  WarGame
 * @author   Yuki Okada
 * @license  
 * @link     
 */

require 'card.php';
require 'player.php';
require 'wargame.php';

$game = new WarGame($playerNames);
$game->startGame();
?>
