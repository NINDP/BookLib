<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name,
            'content' => $this->faker->text(900),
            'description' => $this->faker->sentence(),
            'type' => 'book',
            'path_to_image' => '/book.png'
            // Другие поля книги
        ];
    }
}
