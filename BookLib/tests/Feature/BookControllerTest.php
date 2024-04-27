<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBookPart()
    {
        $book = Book::factory()->create();

        $response = $this->get("/api/book/{$book->id}/excerpt");

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $book->id,
        ]);
    }

    public function testBookPartWithInvalidId()
    {
        $nonExistingBookId = 999;

        $response = $this->getJson("/api/book/{$nonExistingBookId}/excerpt");

        $response->assertStatus(500);

        $response->assertJson(['error' => 'Произошла ошибка при получении информации о части книги']);
    }
}
