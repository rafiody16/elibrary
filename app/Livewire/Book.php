<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book as Books;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class Book extends Component
{
    use WithFileUploads;
    public $id_book, $id_category, $name_book, $cover_book, $existing_cover, $author, $publisher, $publication_date, $description, $stock, $isbn, $showModal = false;

    protected $listeners = [
        'deleteBookListener' => 'deleteBook'
    ];

    public function rules()
    {
        return [
            'id_category' => 'required|exists:categories,id_category',
            'name_book' => 'required|string|max:255',
            'cover_book' => 'required|image|max:2048',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
            'isbn' => 'required|string|max:20',
        ];
    }

    public function rulesUpdate()
    {
        return [
            'id_category' => 'required|exists:categories,id_category',
            'name_book' => 'required|string|max:255',
            'cover_book' => 'nullable|image|max:2048', // <== NOT REQUIRED
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
            'isbn' => 'required|string|max:20',
        ];
    }

    public function render()
    {
        return view('livewire.book.book', [
            'books' => Books::with('category')->paginate(10),
            'categories' => Category::all(),
        ]);
    }

    public function resetFields()
    {
        $this->id_book = null;
        $this->name_book = '';
        $this->cover_book = '';
        $this->existing_cover = '';
        $this->author = '';
        $this->publisher = '';
        $this->publication_date = '';
        $this->description = '';
        $this->stock = 0;
        $this->isbn = '';
    }

    public function addBook()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function storeBook()
    {
        $this->validate($this->rules());
        try {
            if ($this->cover_book) {
                $coverPath = Storage::disk('public')->makeDirectory('books');
                $coverPath = $this->cover_book->store('books', 'public');
            } else {
                $coverPath = null;
            }

            Books::create([
                'id_category' => $this->id_category,
                'name_book' => $this->name_book,
                'cover_book' => $coverPath,
                'author' => $this->author,
                'publisher' => $this->publisher,
                'publication_date' => $this->publication_date,
                'description' => $this->description,
                'stock' => $this->stock,
                'isbn' => $this->isbn,
            ]);

            session()->flash('success', 'Book added successfully.');
            $this->resetFields();
            $this->showModal = false;
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add book: ' . $e->getMessage());
        }
    }

    public function editBook($id)
    {
        $book = Books::find($id);
        if ($book) {
            $this->id_category = $book->id_category;
            $this->id_book = $book->id_book;
            $this->name_book = $book->name_book;
            $this->existing_cover = $book->cover_book; 
            $this->cover_book = null;
            $this->author = $book->author;
            $this->publisher = $book->publisher;
            $this->publication_date = $book->publication_date;
            $this->description = $book->description;
            $this->stock = $book->stock;
            $this->isbn = $book->isbn;
            $this->showModal = true;
        } else {
            session()->flash('error', 'Book not found.');
        }
    }

    public function updateBook()
    {
        $this->validate($this->rulesUpdate());

        try {
            $book = Books::find($this->id_book);
            if ($book) {
                if ($this->cover_book) {
                    if ($book->cover_book && Storage::exists($book->cover_book)) {
                        Storage::delete($book->cover_book);
                    }
                    $coverPath = $this->cover_book->store('books', 'public');
                } else {
                    $coverPath = $this->existing_cover;
                }

                $book->update([
                    'id_category' => $this->id_category,
                    'name_book' => $this->name_book,
                    'cover_book' => $coverPath,
                    'author' => $this->author,
                    'publisher' => $this->publisher,
                    'publication_date' => $this->publication_date,
                    'description' => $this->description,
                    'stock' => $this->stock,
                    'isbn' => $this->isbn,
                ]);

                session()->flash('message', 'Book updated successfully.');
                $this->resetFields();
                $this->showModal = false;
            } else {
                session()->flash('error', 'Book not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update book: ' . $e->getMessage());
        }
    }

    public function cancelPost()
    {
        $this->resetFields();
        $this->showModal = false;
    }

    public function deleteBook($id)
    {
        try {
            $book = Books::find($id);
            if ($book) {
                if ($book->cover_book && Storage::exists($book->cover_book)) {
                    Storage::delete($book->cover_book);
                }

                $book->delete();
                session()->flash('message', 'Book deleted successfully.');
            } else {
                session()->flash('error', 'Book not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete book: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->showModal = false;
    }
}
