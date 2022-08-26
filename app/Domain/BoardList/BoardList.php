<?php
declare(strict_types=1);

namespace App\Domain\BoardList;

use App\Domain\BaseModel;
use App\Domain\Board\Board;
use App\Domain\Card\Card;
use App\Domain\Id;
use Database\Factories\BoardListFactory;

/**
 *
 * @property Id $id
 * @property string $name
 * @property int $sequence
 * @property Board $board
 */
final class BoardList extends BaseModel
{
    public const NAME_LENGTH = 100;
    /**
     * @var string
     */
    protected $table = 'lists';

    protected $fillable = [
        'id', 'name', 'board_id', 'sequence'
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function card()
    {
        return $this->hasMany(Card::class, 'list_id', 'id');
    }

    protected static function newFactory()
    {
        return BoardListFactory::new();
    }
}
