<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Services\CandidateApiService;


class BooksController extends Controller
{
    private $candidateApi;

    public function __construct(CandidateApiService $candidateApi)
    {
        $this->candidateApi = $candidateApi;
    }

   /**
     * Show the form to create a new book.
     */
    public function create()
    {
        $queryParams = [
            "orderBy" => 'id',
            "direction" => 'ASC',
            "limit" => 100,
        ];
        $authors = $this->candidateApi->getAuthors($queryParams);

        if (isset($authors['error'])) {
            return redirect('/login')->with('error', 'Failed to load authors.');
        }

        return view('books.create',['authors'=>$authors['items']]);
    }

    /**
     * Store the new book in the API.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'description' => 'required|string',
            'isbn' => 'required|string',
            'format' => 'required|string',
            'number_of_pages' => 'required|integer|min:1',
            'author' => 'required|integer',
        ]);
    
        // Restructure data to match the required format
        $structuredData = [
            "author" => ["id" => $validatedData['author']],
            "title" => $validatedData['title'],
            "release_date" => $validatedData['release_date'],
            "description" => $validatedData['description'],
            "isbn" => $validatedData['isbn'],
            "format" => $validatedData['format'],
            "number_of_pages" => (int) $validatedData['number_of_pages'],
        ];

        $response = $this->candidateApi->createBook($structuredData);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors($response['error']);
        }

        return redirect('/books/create')->with('success', 'Book added successfully.');
    }

    public function destroy($id)
    {
        $response = $this->candidateApi->deleteBook($id);

        return back()->with('success', 'Book deleted successfully.');
    }
}
