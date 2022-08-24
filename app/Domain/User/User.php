<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\BaseModel;
use App\Domain\Board\Board;
use App\Domain\Id;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * @property Id $id
 * @property string $name
 * @property string $email
 * @property Status $status
 * @property string $passwordHash
 */
final class User extends BaseModel implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    /**
     * @var string
     */
    protected $table = 'users';

    protected $hidden = [
        'passwordHash',
    ];

    protected $fillable = [
        'id', 'name', 'email', 'passwordHash', 'status'
    ];

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Status::tryFrom($value),
            set: fn (Status $value) => $value->value,
        );
    }

    public static function signup(Id $id, string $name, string $email, string $passwordHash): self
    {
        return new User([
            'id' => $id,
            'name' => $name,
            'status' => Status::WAIT,
            'email' => $email,
            'passwordHash' => $passwordHash,
        ]);
    }

    public function signupConfirm(): void
    {
        $this->status = Status::ACTIVE;
    }
}
