<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseModel;
use App\Domain\Id;
use Database\Factories\BoardListFactory;

/**
 * @property Id $id
 * @property string $name
 * @property int $sequence
 * @property Board $board
 */
final class BoardList extends BaseModel
{
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

    protected static function newFactory()
    {
        return BoardListFactory::new();
    }
}
