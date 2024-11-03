<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // List all books
    public function index()
    {
        return Book::all(); // Returns all books in JSON format
    }

    // Show details of a specific book
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return $book; // Returns the specific book in JSON format
    }

    // Create a new book
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'published_year' => 'required|integer',
            'genre' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); // Store in public/images
            $data['image'] = $path; // Store path in the database
        }

        $book = Book::create($data); // Create new book
        return response()->json($book, 201); // Return created book with 201 status
    }

    // Update an existing book
    public function update(Request $request, $id)
    {
        // Find the book by ID
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Define validation rules
        $data = $request->validate([
            'title' => 'sometimes|string', // Title is optional
            'author' => 'sometimes|required|string',
            'published_year' => 'sometimes|required|integer',
            'genre' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

            // Store new image
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path; // Update the path in the data array
        }

        // Update book details
        $book->update($data);

        // Return updated book
        return response()->json($book, 200); // Return a 200 OK response with the updated book
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Delete image if it exists
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete(); // Delete book from database
        return response()->json(['message' => 'Book deleted successfully']); // Return success message
    }
}
