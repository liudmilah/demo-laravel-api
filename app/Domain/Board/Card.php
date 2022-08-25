<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseModel;
use App\Domain\Id;
use Database\Factories\CardFactory;

/**
 * @property Id $id
 * @property string $name
 * @property string $description
 * @property int $sequence
 * @property BoardList $list
 * @property Label $label
 */
final class Card extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'cards';

    public function list()
    {
        return $this->belongsTo(BoardList::class);
    }

    public function label()
    {
        return $this->hasOne(Label::class);
    }

    protected static function newFactory()
    {
        return CardFactory::new();
    }
}
