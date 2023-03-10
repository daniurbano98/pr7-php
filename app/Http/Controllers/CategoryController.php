<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(4);
        return view('categories.index', ['categories'=> $categories] );
    }


    public function edit($id)
    {
        $category = DB::table('categories')->where('id', $id)->get();
        
        if ($category->isEmpty()) {
            return response()->view('categories.404', [], 404);
        } else {
            return view('categories.edit', ['category' => $category[0]]);
        }

       
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories|regex:/^[^0-9]*$/|min:4|max:30'
        ]);

        $affected = DB::table('categories')->where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('index');

    }

    public function destroy($id)
    {  
        $category = DB::table('categories')->where('id', $id)->get();
      
        if ($category->isEmpty()) {
            return response()->view('404', [], 404);
        } else {
            $book = DB::table('categories')->where('id', $id)->delete();
            return redirect()->route('index');
        }
    }
}


