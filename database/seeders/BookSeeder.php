<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'published_year' => 1925,
                'genre' => 'Novel',
                'description' => 'A story about the American dream.',
                'image' => null // Placeholder for image
            ],
            // Add more book entries as needed...
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
