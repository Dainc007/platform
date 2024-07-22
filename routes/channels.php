<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.Conversation.{id}', function ($conversation, $id) {
return true;
});

Broadcast::channel('conversations.{id}', function () {
    return true;
});
