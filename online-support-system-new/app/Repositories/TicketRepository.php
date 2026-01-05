<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository
{
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function findById(int $id): ?Ticket
    {
        return Ticket::with(['replies', 'agent'])->find($id);
    }

    public function findByReference(string $reference): ?Ticket
    {
        return Ticket::with(['publicReplies'])
            ->where('reference_number', $reference)
            ->first();
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Ticket::with('agent')->latest();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('customer_name', 'like', "%{$filters['search']}%")
                    ->orWhere('email', 'like', "%{$filters['search']}%")
                    ->orWhere('reference_number', 'like', "%{$filters['search']}%");
            });
        }

        return $query->paginate($perPage);
    }
}
