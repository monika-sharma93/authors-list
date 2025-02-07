<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CandidateApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    private $candidateApi;

    public function __construct(CandidateApiService $candidateApi)
    {
        $this->candidateApi = $candidateApi;
    }

    public function login(Request $request)
    {
        $response = $this->candidateApi->login();
        if (isset($response['token_key'])) {
            return redirect()->route('authors.index')->with('success', 'Login successful!');
        }
        return view('auth.login');

    }

    public function logout()
    {
        Session::forget('access_token');
        Session::forget('refresh_token');
        return redirect()->route('login');
    }
}
