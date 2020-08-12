<?php

namespace App\Http\Controllers;
use App\Book;

use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $books = Book::where('deleted', false)->get();
            foreach ($books as $book) {
                $book->isEditing = false;
            }

            return response()->json(['success' => true, 'data' => $books]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong! Unable to get the book list']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $book = Book::create($request->all());
            return response()->json(['success' => true, 'message' => 'Book added successfully']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong! Unable to add book']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            $book = Book::find($id);
            $book->name = $request->name;
            $book->author = $request->author;
            $book->genre = $request->genre;
            $book->save();
            return response()->json(['success' => true, 'data' => 'Book successfully updated']);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong! Unable to update book']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $book = Book::find($id);
            $book->deleted = true;
            $book->save();
            return response()->json(['success' => true, 'data' => 'Book successfully removed']);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong! Unable to remove book']);
        }
    }
}
