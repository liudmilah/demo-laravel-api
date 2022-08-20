<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\BaseModel;
use App\Domain\Board\Board;
use App\Domain\Id;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;

/**
 * @property Id $id
 * @property string $name
 * @property string $email
 * @property string $passwordHash
 */
final class User extends BaseModel
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    protected $hidden = [
        'passwordHash',
    ];

    protected $fillable = [
        'id', 'name', 'email', 'passwordHash',
    ];

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
