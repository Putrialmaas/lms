<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Carbon\Carbon;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        if (empty($search)) {
        $books = DB::table('books')
        ->select(
            DB::raw("
                books.id as id, books.title as title, books.year as year, libraries.id as library_id, libraries.name as library_name, publishers.id as publisher_id, publishers.name as 
                publisher_name, categories.id as category_id, categories.name as category_name, books.deleted_at as deleted_at
                ")
            )
                ->where("books.deleted_at", "=", null)
                ->join("libraries", "libraries.id", '=', "library_id")
                ->join("publishers", "publishers.id", '=', "publisher_id")
                ->join("categories", "categories.id", '=', "category_id")
                ->get();
        } else {
            $books = DB::table('books')
            ->select(
                DB::raw("
                    books.id as id, books.title as title, books.year as year, libraries.id as library_id, libraries.name as library_name, publishers.id as publisher_id, publishers.name as 
                    publisher_name, categories.id as category_id, categories.name as category_name, books.deleted_at as deleted_at
                    ")
                )
                    ->where("books.deleted_at", "=", null)
                    ->where("books.title", "like", "%$search%")
                    ->join("libraries", "libraries.id", '=', "library_id")
                    ->join("publishers", "publishers.id", '=', "publisher_id")
                    ->join("categories", "categories.id", '=', "category_id")
                    ->get();  
        }
        return Inertia::render('Books/Index', [
            'books'=> $books
        ]);  
    }

    public function trashed(Request $request)
    {
        $trashedBooks = DB::table("books")
            ->select(
                DB::raw("
                books.id as id, books.title as title, books.year as year, libraries.id as library_id, libraries.name as library_name, publishers.id as publisher_id, publishers.name as 
                publisher_name, categories.id as category_id, categories.name as category_name, books.deleted_at as deleted_at
                ")
                )
                ->where("books.deleted_at", "!=", null)
                ->join("libraries", "libraries.id", '=', "library_id")
                ->join("publishers", "publishers.id", '=', "publisher_id")
                ->join("categories", "categories.id", '=', "category_id")
                ->get();
        
        return Inertia::render("Books/Trashed", [
            "trashed_books" => $trashedBooks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $libraries = DB::table("libraries")
            ->select(DB::raw("id, name, address, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $publishers = DB::table("publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $categories = DB::table("categories")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        return Inertia::render('Books/Create', [
            'libraries'=> $libraries,
            'publishers'=> $publishers,
            'categories'=> $categories,
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::validate(
            $request->all(),
            [
                "library" => ["required", "integer", "exists:libraries,id"],
                "publisher" => ["required", "integer", "exists:publishers,id"],
                "category" => ["required", "integer", "exists:categories,id"],
                "title" => ["required", "string", "max:255"],
                "year" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "library" => "book library",
                "publisher" => "book publisher",
                "category" => "book category",
                "name" => "book name",
                "year" => "book year",

            ]
            );
        DB::table("books")->insert([
            "library_id" => $request->library,
            "publisher_id" => $request->publisher,
            "category_id" => $request->category,
            "title" => $request->title,
            "year" => $request->year,
        ]);
        return Redirect::route("books.index");
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $libraries = DB::table("libraries")
            ->select(DB::raw("id, name, address, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $publishers = DB::table("publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $categories = DB::table("categories")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $book = DB::table('books')
        ->select(
            DB::raw("
                books.id as id, books.title as title, books.year as year, libraries.id as library_id, libraries.name as library_name, publishers.id as publisher_id, publishers.name as 
                publisher_name, categories.id as category_id, categories.name as category_name, books.deleted_at as deleted_at
                ")
        )
        ->where("books.id", "=", $id)
        ->where("books.deleted_at", "=", null)
        ->join("libraries", "libraries.id", '=', "library_id")
        ->join("publishers", "publishers.id", '=', "publisher_id")
        ->join("categories", "categories.id", '=', "category_id")
        ->get();

        return Inertia::render("Books/Edit", [
            "libraries" => $libraries,
            "publishers" => $publishers,
            "categories" => $categories,
            "book" => $book[0],
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::validate(
            $request->all(),
            [
                "library" => ["required", "integer", "exists:libraries,id"],
                "publisher" => ["required", "integer", "exists:publishers,id"],
                "category" => ["required", "integer", "exists:categories,id"],
                "title" => ["required", "string", "max:255"],
                "year" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "library" => "book library",
                "publisher" => "book publisher",
                "category" => "book category",
                "name" => "book name",
                "year" => "book year",

            ]
        );
        DB::table("books")
        ->where("id", "=", $id)
        ->update([
            "library_id" => $request->library,
            "publisher_id" => $request->publisher,
            "category_id" => $request->category,
            "title" => $request->title,
            "year" => $request->year,
            "updated_at" => Carbon::now(),
        ]);
        return Redirect::route("books.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("books")
        ->where("id", "=", $id)
        ->update([
            "deleted_at" => Carbon::now(),
        ]);
        return back();
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_permanent($id)
    {
        DB::table("books")
            ->where("id", "=", $id)
            ->delete();
        return back();
    }

    /**
     * Restore the specified trashed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        DB::table("books")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}