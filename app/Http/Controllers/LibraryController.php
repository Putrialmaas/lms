<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Carbon\Carbon;

class LibraryController extends Controller
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
            $libraries = DB::table("libraries")
                ->select(DB::raw("id, name, address, deleted_at"))
                ->where("libraries.deleted_at", "=", null)
                ->get();
        } else {
            $libraries = DB::table('libraries')
                ->select(DB::raw("id, name, address, deleted_at"))
                ->where("libraries.deleted_at", "=", null)
                ->where("libraries.name", "like", "%$search%")
                ->get();
        }
            return Inertia::render("Libraries/Index", [
                "libraries" => $libraries,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $trashedLibraries = DB::table("libraries")
            ->select(DB::raw("id, name, address, deleted_at"))
            ->where("libraries.deleted_at", "!=", null)
            ->get();
        return Inertia::render("Libraries/Trashed", [
            "trashed_libraries" => $trashedLibraries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Libraries/Create");
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
                "name" => ["required", "string", "max:255"],
                "address" => ["required", "string"],
            ],
            [],
            [
                "name" => "library name",
                "address" => "library address",
            ]
        );
        DB::table("libraries")->insert([
            "name" => $request->name,
            "address" => $request->address,
        ]);
        return Redirect::route("libraries.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $library = DB::table("libraries")
        ->where("id", "=", $id)
        ->get();
        return Inertia::render("Libraries/Edit", [
            "library" => $library[0],
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
                "name" => ["required", "string", "max:255"],
                "address" => ["required", "string"],
            ],
            [],
            [
                "name" => "library name",
                "address" => "library address"
            ]
        );
        DB::table("libraries")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "address" => $request->address,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("libraries.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("libraries")
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
        DB::table("libraries")
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
        DB::table("libraries")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
