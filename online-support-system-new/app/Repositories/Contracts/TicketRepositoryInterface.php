<?php

namespace App\Repositories\Contracts;

use App\Models\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketRepositoryInterface
{
    public function create(array $data): Ticket;
    public function findById(int $id): ?Ticket;
    public function findByReference(string $reference): ?Ticket;
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function update(Ticket $ticket, array $data): bool;
    public function assignAgent(Ticket $ticket, int $agentId): bool;
    public function addReply(Ticket $ticket, array $replyData): void;
}
