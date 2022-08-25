<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseModel;
use App\Domain\Id;
use Database\Factories\LabelFactory;

/**
 * @property Id $id
 * @property string $color
 */
final class Label extends BaseModel
{
    public const COLORS = ['red', 'yellow', 'pink', 'orange', 'violet', 'blue', 'green'];

    /**
     * @var string
     */
    protected $table = 'labels';

    public $timestamps = false;

    protected static function newFactory()
    {
        return LabelFactory::new();
    }
}
