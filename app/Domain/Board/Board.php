<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseModel;
use App\Domain\Id;
use App\Domain\User\User;

/**
 * @property Id $id
 * @property string $name
 * @property User $user
 */
final class Board extends BaseModel
{
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
}
