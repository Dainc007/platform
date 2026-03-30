<?php

use App\Notifications\Admin\NewUserRegisteredNotification;
use Illuminate\Support\Facades\Notification;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register and admins are notified', function () {
    Notification::fake();

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = \App\Models\User::where('email', 'test@example.com')->first();
    $this->assertFalse($user->is_active);

    Notification::assertSentOnDemand(
        NewUserRegisteredNotification::class,
        function ($notification, $channels, $notifiable) use ($user) {
            return $notifiable->routes['mail'] === 'kontakt@partio.pl' &&
                   $notification->user->id === $user->id;
        }
    );
});
