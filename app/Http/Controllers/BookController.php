<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->get();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function getBooksByCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
        }

        $books = $category->books;

        return response()->json($books, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}
