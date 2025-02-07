<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Services\CandidateApiService;


class AuthorController extends Controller
{
    private $candidateApi;

    public function __construct(CandidateApiService $candidateApi)
    {
        $this->candidateApi = $candidateApi;
    }

    public function index()
    {

        $queryParams = [
            "orderBy" => 'id',
            "direction" => 'ASC',
            "limit" => 10,
        ];
        $authors = $this->candidateApi->getAuthors($queryParams);
        

        if (empty($authors) || isset($authors['error'])) {
            return redirect('/login')->with('error', $authors['error']);
        }

        foreach($authors['items'] as &$author){
            $fetchAuthor = $this->candidateApi->getAuthorById($author['id']);
            if(!empty($fetchAuthor['id']))
                $author['books_count'] = count($fetchAuthor['books']);
        }

        return view('authors.authors', ['authors'=>$authors['items'],'results'=>$authors]);
    }

    /**
     * Show a single author and their books.
     */
    public function show($id)
    {
        $author = $this->candidateApi->getAuthorById($id);

        if (isset($author['error'])) {
            return redirect('/authors')->with('error', $author['error']);
        }


        return view('authors.show', compact('author'));
    }

    public function destroy($id)
    {
        $response = $this->candidateApi->deleteAuthor($id);

        if (isset($response['error'])) {
            return back()->with('error', 'Author cannot be deleted. Ensure no books are linked.');
        }

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
