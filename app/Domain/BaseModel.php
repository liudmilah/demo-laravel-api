<?php
declare(strict_types=1);

namespace App\Domain;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property Id $id
 */
class BaseModel extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    protected function id(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => new Id($value),
            set: fn (Id $value) => $value->getValue(),
        );
    }

    public function getAttribute($key): mixed
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        }

        return parent::getAttribute(Str::snake($key));
    }

    public function setAttribute($key, $value): mixed
    {
        return parent::setAttribute(Str::snake($key), $value);
    }
}
