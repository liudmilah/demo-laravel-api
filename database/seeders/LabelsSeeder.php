<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Card\Label;
use Illuminate\Database\Seeder;

class LabelsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Label::COLORS as $color) {
            Label::factory()
                ->color($color)
                ->create();
        }

    }
}
