<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(4);
        $categories = Category::all();
        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        return view('books.createBook');
    }

    public function show($id)
    {
        $book = DB::table('books')->where('id', $id)->get();
        if ($book->isEmpty()) {
            return response()->view('404', [], 404);
        } else {
            return view('books.show', ['book' => $book[0]]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'isbn' => 'required|unique:books|regex:/^[^a-zA-Z]*$/|min:13|max:13',
            'author' => 'required|regex:/^[^0-9]*$/|min:3|max:40',
            'title' => 'required|min:2|max:40',
            'published_date' => 'required|date|before:2023-03-09',
            'description' => 'required|max:200',
            'price' => 'required'
        ]);



        $book = DB::table('books')->insert([
            'isbn' => $request->isbn,
            'author' => $request->author,
            'title' => $request->title,
            'published_date' => $request->published_date,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return redirect()->route('books.index');
    }
    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->get();
        if ($book->isEmpty()) {
            return response()->view('404', [], 404);
        } else {
            return view('books.edit', ['book' => $book[0]]);
        }
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'isbn' => 'required|unique:books|regex:/^[^a-zA-Z]*$/|min:13|max:13',
            'author' => 'required|regex:/^[^0-9]*$/|min:3|max:40',
            'title' => 'required|min:2|max:40',
            'published_date' => 'required|date|before:2023-03-09',
            'description' => 'required|max:200',
            'price' => 'required'
        ]);

        $affected = DB::table('books')->where('id', $request->id)->update([
            'isbn' => $request->isbn,
            'author' => $request->author,
            'title' => $request->title,
            'published_date' => $request->published_date,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return redirect()->route('books.index');

    }

    public function destroy($id)
    {  
        $book = DB::table('books')->where('id', $id)->get();
      
        if ($book->isEmpty()) {
            return response()->view('404', [], 404);
        } else {
            $book = DB::table('books')->where('id', $id)->delete();
            return redirect()->route('books.index');
        }
    }

    public function getBooksForCategory(Request $request){
        $categories = Category::all();
        $category = Category::find($request->input('category_id'));
        $books = $category->books()->paginate(4);
        return view('books.index', compact('books', 'categories'));
    }
}