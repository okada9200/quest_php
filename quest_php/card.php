<?php
/**
 * Cardについてのクラス。
 *
 * @category Card
 * @package  WarGame
 * @author   Yuki Okada
 * @license  
 * @link     
 */
class Card
{
    public $value; //数字
    public $suit; //マーク

    /**
     * Cardコンストラクター
     *
     * @param string $value カードの値
     * @param string $suit  マーク
     */
    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    /**
     * カードの表示文字列を取得。
     *
     * @return string カードの表示文字列
     */
    public function display()
    {
        if ($this->value === 'Joker') {
            return $this->value; //Jokerの場合はsuitを返さない
        } else {
            return "{$this->suit}の{$this->value}";
        }
    }

    /**
     * スペードのAを一番強いカードにする。
     *
     * @return bool スペードのAならtrue、そうでなければfalse
     */
    public function spadeOfAce()
    {
        return $this->value === 'A' && $this->suit === 'スペード';
    }
}

?>

