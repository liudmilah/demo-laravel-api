<?php
declare(strict_types=1);

namespace App\Domain\Card;

use App\Domain\BaseModel;
use App\Domain\BoardList\BoardList;
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
    public const NAME_LENGTH = 100;
    public const DESCR_LENGTH = 10000;
    /**
     * @var string
     */
    protected $table = 'cards';

    protected $fillable = [
        'id', 'name', 'description', 'sequence', 'list_id',
    ];

    public function list()
    {
        return $this->belongsTo(BoardList::class, 'list_id', 'id');
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
