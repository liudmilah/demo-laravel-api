<?php
declare(strict_types=1);

namespace App\Domain\Card\Command\Update;

use App\Domain\Card\Card;
use App\Domain\Card\CardRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private CardRepository $cards) {}

    public function handle(Command $command): void
    {
        $card = $this->assertCardExists($command->cardId, $command->listId, $command->boardId, $command->userId);
        $this->assertNameIsUnique($card, $command->name, $command->boardId);
        $this->assertSequenceIsUnique($card, $command->sequence, $command->listId);

        $card->name = $command->name;
        $card->description = $command->description;
        $card->sequence = $command->sequence;

        $this->cards->update($card);
    }

    private function assertCardExists(Id $cardId, Id $listId, Id $boardId, Id $userId): Card
    {
        if (!$card = $this->cards->findOne($cardId, $listId, $boardId, $userId)) {
            throw new \DomainException('Card not found.');
        }

        return $card;
    }

    private function assertNameIsUnique(Card $card, string $name, Id $boardId)
    {
        if ($card->name !== $name && $this->cards->hasByName($name, $boardId)) {
            throw new \DomainException('Name is not unique.');
        }
    }

    private function assertSequenceIsUnique(Card $card, int $sequence, Id $listId)
    {
        if ($card->sequence !== $sequence && $this->cards->hasBySequence($sequence, $listId)) {
            throw new \DomainException('Sequence is not unique.');
        }
    }
}
