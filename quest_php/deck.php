<?php
/**
 * プレイ用デッキについてのクラス
 *
 * @category Deck
 * @package  WarGame
 * @author   Yuki Okada
 * @license  
 * @link    
 */
class Deck
{
    public $cards; // カードの配列

    /**
     * Deckコンストラクター
     */
    public function __construct()
    {
        $this->_initializeDeck();
        $this->_shuffleDeck();
    }

    /**
     * デッキを初期化
     *
     * @return void
     */
    private function _initializeDeck()
    {
        $suits = ['ハート', 'ダイヤ', 'スペード', 'クラブ'];
        $ranks = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2'];
        $this->cards = [];
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new Card($suit, $rank);
            }
        }
    }

    /**
     * デッキをシャッフル
     *
     * @return void
     */
    private function _shuffleDeck()
    {
        shuffle($this->cards);
    }

    /**
     * カードを引く
     *
     * @return Card 引かれたカード
     */
    public function drawCard()
    {
        return array_shift($this->cards);
    }
}
?>
