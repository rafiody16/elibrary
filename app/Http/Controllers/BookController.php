<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('book.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('book.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'id_category' => 'required|integer|exists:categories,id_category',
            'name_book' => 'required|string|max:75',
            'cover_book' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:50',
            'publisher' => 'required|string|max:50',
            'publication_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        if ($request->hasFile('cover_book')) {
            $coverPath = $request->file('cover_book')->store('books', 'public');
        } else {
            $coverPath = null;
        }

        Book::create([
            'id_category' => $request->id_category,
            'name_book' => $request->name_book,
            'cover_book' => $coverPath,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_date' => $request->publication_date,
            'description' => $request->description,
            'stock' => $request->stock,
            'isbn' => Str::random(16),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
        ]);
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('book.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'id_category' => 'required|integer|exists:categories,id_category',
            'name_book' => 'required|string|max:75',
            'cover_book' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:50',
            'publisher' => 'required|string|max:50',
            'publication_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        $book = Book::findOrFail($id);

        if ($request->hasFile('cover_book')) {
            if ($book->cover_book) {
                Storage::disk('public')->delete($book->cover_book);
            }
            $coverPath = $request->file('cover_book')->store('books', 'public');
        } else {
            $coverPath = $book->cover_book;
        }

        $book->update([
            'id_category' => $request->id_category,
            'name_book' => $request->name_book,
            'cover_book' => $coverPath,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_date' => $request->publication_date,
            'description' => $request->description,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->cover_book) {
            Storage::disk('public')->delete($book->cover_book);
        }
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully',
        ]);
    }

    public function getAvailableBookByUser(Request $request, $id)
    {
        
    }
}
