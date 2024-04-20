
<?php
/**
 * 戦争ゲームのプレイ内容について
 *
 * @category  Game
 * @package   WarGame
 * @author    Yuki Okada
 * @license   
 * @link      
 */
class WarGame
{
    public $players;

    /**
     * WarGameコンストラクター
     *
     * @param array $playerNames プレイヤーの名前が含まれる配列。
     */
    public function __construct($playerNames)
    {
        $this->players = [];
        foreach ($playerNames as $name) {
            $this->players[] = new Player($name);
        }
    }

    /**
     * ゲームを開始
     *
     * @return void
     */
    public function startGame()
    {
        echo "戦争を開始します。\n";

        // カードの生成
        $deck = [];
        $suits = ['ハート', 'ダイヤ', 'スペード', 'クラブ'];
        $values = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2', 'Joker'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $deck[] = new Card($value, $suit);
            }
        }

        // カードをシャッフル
        shuffle($deck);

        // カードを配る
        $playerCount = count($this->players);
        for ($i = 0; $i < count($deck); $i++) {
            $this->players[$i % $playerCount]->drawCard($deck[$i]);
        }

        echo "カードが配られました。\n";

        $round = 1;
        while ($this->gamePlayOn()) {
            echo "戦争！\n";
            $this->playRound($round);
            $round++;
        }

        $this->endGame();
    }

    /**
     * ラウンドをプレイ
     *
     * @param int $round 現在のラウンド番号
     *
     * @return void
     */
    public function playRound($round)
    {
        $playedCards = [];
        foreach ($this->players as $player) {
            if ($player->hasCards()) {
                $card = $player->playCard();
                echo "{$player->name}のカードは{$card->display()}です。\n";
                $playedCards[$player->name] = $card;
            }
        }

        if (empty($playedCards)) {
            echo "プレイヤーの手札がなくなったため、ゲームを終了します。\n";
            return;
        }

        $winningPlayer = $this->compareCards($playedCards);

        if ($winningPlayer) {
            echo "{$winningPlayer->name}が勝ちました。\n";
            $this->giveCards($winningPlayer, $playedCards);
        } else {
            echo "引き分けです。\n";
        }
    }

    /**
     * カードを比較し、勝利プレイヤーを決定します。
     *
     * @param array $playedCards プレイされたカードが含まれる配列。
     * 
     * @return Player|null 勝利プレイヤー、引き分けの場合はnull。
     */
    public function compareCards($playedCards)
    {
        $values = [];
        foreach ($playedCards as $player => $card) {
            if ($card->spadeOfAce()) {
                return $this->getPlayerName($player); // スペードの A は最強のため、そのプレイヤーが勝利
            }
            $values[$player] = $this->cardValue($card->value);
        }

        arsort($values);
        $keys = array_keys($values);
        $maxValue = reset($values);

        $occurrences = array_count_values($values);
        if ($occurrences[$maxValue] > 1) {
            return null; // 引き分け
        }

        return $this->getPlayerName($keys[0]);
    }

    /**
     * カードの強さを評価します。
     *
     * @param string $value カードの値。
     * 
     * @return int カードの強さ。
     */
    public function cardValue($value)
    {
        $values = ['A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, '10' => 10, '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2, 'Joker' => 15]; // Jokerを最強として値を設定
        return $values[$value] ?? 0; // 無ければ0で返す
    }

    /**
     * プレイヤーにカードを配分。
     *
     * @param Player $player 配る対象のプレイヤー。
     * @param array  $cards  配るカードの配列。
     *
     * @return void
     */
    public function giveCards($player, $cards)
    {
        foreach ($cards as $card) {
            $player->drawCard($card);
        }
    }

    /**
     * 名前からプレイヤーを取得。
     *
     * @param string $name プレイヤー名。
     * 
     * @return Player|null 該当するプレイヤー、存在しない場合はnull。
     */
    public function getPlayerName($name)
    {
        foreach ($this->players as $player) {
            if ($player->name === $name) {
                return $player;
            }
        }
        return null;
    }

    /**
     * ゲームが続行中かどうかを判定。
     * 
     *
     * @return bool 続行中ならtrue、そうでなければfalse。
     */
    public function gamePlayOn()
    {
        $activePlayers = array_filter($this->players, function ($player) {
            return $player->hasCards();
        });

        return count($activePlayers) > 1;
    }

    /**
     * ゲームを終了します。
     *
     * @return void
     */
    public function endGame()
    {
        echo "戦争を終了します。\n";

        // 順位を表示
        usort($this->players, function ($a, $b) {
            return count($b->hand) - count($a->hand);
        });

        foreach ($this->players as $index => $player) {
            echo "{$player->name}が" . ($index + 1) . "位です。";
            echo " 手札の枚数は" . count($player->hand) . "枚です。\n";
        }
    }
}

echo "戦争を開始します。\n";
echo "プレイヤーの人数を入力してください（2〜5）: ";
$playerCount = readline();
if ($playerCount < 2 || $playerCount > 5) {
    echo "プレイヤーの人数は2〜5で入力してください。\n";
    exit;
}

$playerNames = [];
for ($i = 1; $i <= $playerCount; $i++) {
    echo "プレイヤー{$i}の名前を入力してください: ";
    $playerNames[] = readline();
}
?>


