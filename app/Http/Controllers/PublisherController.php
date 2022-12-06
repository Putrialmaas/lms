<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Carbon\Carbon;

class PublisherController extends Controller
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
            $publishers = DB::table('publishers')
                ->select(DB::raw("id, name, deleted_at"))
                ->where("publishers.deleted_at", "=", null)
                ->get();
        } else {
            $publishers = DB::table('publishers')
                ->select(DB::raw("id, name, deleted_at"))
                ->where("publishers.deleted_at", "=", null)
                ->where("publishers.name", "like", "%$search%")
                ->get();
        }
        return Inertia::render('Publishers/Index', [
            'publishers'=> $publishers
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
        $trashedPublishers = DB::table("publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("publishers.deleted_at", "!=", null)
            ->get();
        return Inertia::render("Publishers/Trashed", [
            "trashed_publishers" => $trashedPublishers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Publishers/Create");
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
                
            ],
            [],
            [
                "name" => "publisher name",
                
            ]
        );
        DB::table("publishers")->insert([
            "name" => $request->name,
            
        ]);
        return Redirect::route("publishers.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publisher = DB::table("publishers")
        ->where("id", "=", $id)
        ->get();
        return Inertia::render("Publishers/Edit", [
            "publisher" => $publisher[0],
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
                
            ],
            [],
            [
                "name" => "library name",
                
            ]
        );
        DB::table("publishers")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,                
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("publishers.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("publishers")
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
        DB::table("publishers")
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
        DB::table("publishers")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
