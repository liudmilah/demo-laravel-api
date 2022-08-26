<?php
declare(strict_types=1);

namespace App\Domain\Card\Command\Create;

use App\Domain\BoardList\BoardListRepository;
use App\Domain\Card\Card;
use App\Domain\Card\CardRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private CardRepository $cards, private BoardListRepository $lists) {}

    public function handle(Command $command): Id
    {
        $this->assertListExists($command->listId, $command->boardId, $command->userId);
        $this->assertNameIsUnique($command->name, $command->boardId);
        $this->assertSequenceIsUnique($command->sequence, $command->listId);

        $card = new Card([
            'id' => $id = Id::generate(),
            'name' => $command->name,
            'description' => $command->description,
            'sequence' => $command->sequence,
            'list_id' => $command->listId,
        ]);

        $this->cards->add($card);

        return $id;
    }

    private function assertListExists(Id $listId, Id $boardId, Id $userId): void
    {
        if (!$this->lists->findOne($listId, $boardId, $userId)) {
            throw new \DomainException('List not found.');
        }
    }

    private function assertNameIsUnique(string $name, Id $boardId)
    {
        if ($this->cards->hasByName($name, $boardId)) {
            throw new \DomainException('Name is not unique.');
        }
    }

    private function assertSequenceIsUnique(int $sequence, Id $listId)
    {
        if ($this->cards->hasBySequence($sequence, $listId)) {
            throw new \DomainException('Sequence is not unique.');
        }
    }
}
