<?php

use App\Http\Controllers\Agent\AgentTicketController;
use App\Http\Controllers\Agent\Auth\AgentAuthController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tickets/create', [HomeController::class, 'createTicket'])->name('tickets.create');
Route::get('/tickets/check', [HomeController::class, 'checkTicket'])->name('tickets.check');
Route::get('/tickets/status', [HomeController::class, 'showTicketByReference'])->name('tickets.show-by-reference');
Route::post('/tickets', [HomeController::class, 'storeTicket'])->name('tickets.store');
Route::get('/tickets/{reference}', [HomeController::class, 'showTicket'])->name('tickets.show');
Route::patch('/tickets/{ticket}/status', [AgentTicketController::class, 'updateStatus'])
    ->name('tickets.update-status');

Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('/ticket-status', [AgentTicketController::class, 'ticketStatus'])->name('ticket-status');
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AgentAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AgentAuthController::class, 'login']);
    });
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AgentAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            return view('agent.dashboard');
        })->name('dashboard');

        Route::get('/tickets', [AgentTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AgentTicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/reply', [AgentTicketController::class, 'reply'])->name('tickets.reply');
        Route::post('/tickets/{ticket}/assign', [AgentTicketController::class, 'assign'])->name('tickets.assign');
        Route::post('/tickets/{ticket}/resolve', [AgentTicketController::class, 'resolve'])->name('tickets.resolve');        Route::get('/tickets/all', [AgentTicketController::class, 'all'])->name('tickets.all');
    });
});
