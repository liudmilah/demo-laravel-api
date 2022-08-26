<?php
declare(strict_types=1);

namespace App\Domain\Card\Command\Delete;

use App\Domain\Card\Card;
use App\Exceptions\ItemNotFoundException;
use App\Domain\Card\CardRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private CardRepository $cards) {}

    public function handle(Command $command): void
    {
        $card = $this->assertCardExists($command->cardId, $command->userId);

        $this->cards->delete($card);
    }

    private function assertCardExists(Id $cardId, Id $userId): Card
    {
        if (!$card = $this->cards->findOneByIdAndUser($cardId, $userId)) {
            throw new ItemNotFoundException();
        }

        return $card;
    }
}
