<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MessengerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur authentifié pour les tests
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    /** @test */
    public function it_can_send_a_message()
    {
        // Créer un utilisateur destinataire
        $recipient = User::factory()->create();

        // Préparer les données du message
        $messageData = [
            'message' => 'Bonjour !',
            'id' => $recipient->id,
            'temporaryMsgId' => uniqid()
        ];

        // Envoyer la requête
        $response = $this->postJson('/api/send-message', $messageData);

        // Vérifier la réponse
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'tempID'
                ]);

        // Vérifier que le message a été créé
        $this->assertDatabaseHas('messages', [
            'from_id' => $this->user->id,
            'to_id' => $recipient->id,
            'body' => $messageData['message']
        ]);
    }

    /** @test */
    public function it_can_fetch_messages()
    {
        // Créer un utilisateur destinataire
        $recipient = User::factory()->create();

        // Créer quelques messages de test
        Message::factory()->count(3)->create([
            'from_id' => $this->user->id,
            'to_id' => $recipient->id
        ]);

        // Récupérer les messages
        $response = $this->getJson("/api/messages/{$recipient->id}");

        // Vérifier la réponse
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'last_page',
                    'last_message',
                    'messages'
                ]);

        // Vérifier que les messages sont correctement paginés
        $this->assertEquals(1, $response->json('last_page'));
    }

    /** @test */
    public function it_can_add_favorite()
    {
        // Créer un utilisateur destinataire
        $recipient = User::factory()->create();

        // Ajouter à la liste des favoris
        $response = $this->postJson("/api/favorites/{$recipient->id}");

        // Vérifier la réponse
        $response->assertStatus(200);

        // Vérifier que le favori a été créé
        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'favorite_user_id' => $recipient->id
        ]);
    }

    /** @test */
    public function it_can_search_users()
    {
        // Créer un utilisateur avec un pseudo spécifique
        $user = User::factory()->create([
            'pseudo' => 'TestUser'
        ]);

        // Rechercher l'utilisateur
        $response = $this->getJson("/api/search?query=TestUser");

        // Vérifier la réponse
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'records',
                    'last_page'
                ]);

        // Vérifier que l'utilisateur est dans les résultats
        $this->assertContains(
            $user->id,
            array_column($response->json('records'), 'id')
        );
    }
}
