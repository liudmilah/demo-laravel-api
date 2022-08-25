<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseModel;
use App\Domain\Id;
use App\Domain\User\User;
use Database\Factories\BoardFactory;

/**
 * @property Id $id
 * @property string $name
 * @property User $user
 */
final class Board extends BaseModel
{
    public const NAME_LENGTH = 100;
    /**
     * @var string
     */
    protected $table = 'boards';

    protected $fillable = [
        'id', 'name', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return BoardFactory::new();
    }
}
