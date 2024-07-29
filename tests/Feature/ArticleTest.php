<?php

test('user can delete their article', function () {
    $user = \App\Models\User::factory()->create();
    $article = \App\Models\Article::factory()->create(['user_id' => $user->id]);
    $response = $this->actingAs($user)->delete('articles/' . $article->id);

    $response->assertRedirect(route('articles.index'));
    $this->assertDatabaseMissing('articles', $article->toArray());
} );

test('user cannot delete someone elses article', function () {
    $user = \App\Models\User::factory()->create();
    $article = \App\Models\Article::factory()->create(['user_id' => $user->id]);

    $user2 = \App\Models\User::factory()->create();
    $response = $this->actingAs($user2)->delete('articles/' . $article->id);

    $response->assertForbidden();
    $this->assertDatabaseHas('articles', $article->toArray());
});
