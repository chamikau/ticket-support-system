<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'customer_name',
        'email',
        'phone',
        'problem_description',
        'status',
        'priority',
        'agent_id',
        'opened_at',
        'resolved_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->reference_number = 'TICKET-' . strtoupper(uniqid());
        });
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at');
    }

}
