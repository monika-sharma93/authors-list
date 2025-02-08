<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CandidateApiService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api_base_url'); // Get API base URL from .env
    }

    /**
     * Get access token from session or refresh it if expired.
     *
     * @return string|null
     */
    private function getAccessToken()
    {
        $accessToken = Session::get('access_token');
        $tokenExpiry = Session::get('token_expiry');

        // Check if token is missing or expired
        if (!$accessToken || now()->greaterThan($tokenExpiry)) {
            Log::info('Token expired or missing. Refreshing token...');
            $newToken = $this->refreshToken();

            if (isset($newToken['access_token'])) {
                return $newToken['access_token'];
            } else {
                return null;
            }
        }

        return $accessToken;
    }

    /**
     * Refresh the access token using the API refresh token endpoint.
     *
     * @return array
     */
    private function refreshToken()
    {
        $refreshToken = Session::get('refresh_token');

        if (!$refreshToken) {
            Log::error('No refresh token found in session.');
            return ['error' => 'Unauthorized: No refresh token available.'];
        }

        // Call the API to refresh the token
        $response = Http::post("{$this->apiUrl}/token/refresh", [
            'refresh_token' => $refreshToken,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('access_token', $data['access_token']);
            Session::put('refresh_token', $data['refresh_token']); // Save new refresh token
            Session::put('token_expiry', now()->addMinutes(30)); // Adjust expiry as per API

            return $data;
        }

        Log::error('Failed to refresh token.', ['response' => $response->json()]);
        return ['error' => 'Failed to refresh token'];
    }

    /**
     * Authenticate user and get a new token.
     *
     * @return array
     */
    public function login(array $credentials)
    {
        $response = Http::post("{$this->apiUrl}/token", [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('access_token', $data['token_key']);
            Session::put('refresh_token', $data['refresh_token_key']); // Store refresh token
            Session::put('token_expiry', $data["expires_at"]);

            return $data;
        }

        return ['error' => 'Login failed'];
    }

    /**
     * Fetch the list of authors from the API.
     *
     * @param array $queryParams
     * @return array
     */
    public function getAuthors(array $queryParams = [])
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['error' => 'Unauthorized: No API token found.'];

        $response = Http::withToken($accessToken)->get("{$this->apiUrl}/authors", $queryParams);
        return $response->successful() ? $response->json() : [];
    }

    /**
     * Retrieve a single author by ID.
     *
     * @param int $id
     * @return array
     */
    public function getAuthorById($id)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['error' => 'Unauthorized: No API token found.'];

        $response = Http::withToken($accessToken)->get("{$this->apiUrl}/authors/{$id}");

        return $response->successful() ? $response->json() : ['error' => 'Failed to retrieve author.'];
    }

    /**
     * Create a new book via API.
     *
     * @param array $data
     * @return array
     */
    public function createBook($data)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['error' => 'Unauthorized: No API token found.'];

        $response = Http::withToken($accessToken)->post("{$this->apiUrl}/books", $data);
        return $response->successful() ? $response->json() : ['error' => 'Failed to create book.'];
    }

    /**
     * Create a new author via API.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $birthday
     * @param string $biography
     * @param string $gender
     * @param string $placeOfBirth
     * @return array
     */
    public function createAuthor($firstName, $lastName, $birthday, $biography, $gender, $placeOfBirth)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['error' => 'Unauthorized: No API token found.'];

        $response = Http::withToken($accessToken)->post("{$this->apiUrl}/authors", [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "birthday" => $birthday,
            "biography" => $biography,
            "gender" => $gender,
            "place_of_birth" => $placeOfBirth
        ]);

        return $response->successful() ? ['success' => true, 'message' => 'Author created successfully!'] 
            : ['error' => 'Failed to create author.'];
    }

    /**
     * Delete an author by ID.
     *
     * @param int $id
     * @return array
     */
    public function deleteAuthor($id)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['error' => 'Unauthorized: No API token found.'];

        $response = Http::withToken($accessToken)->delete("{$this->apiUrl}/authors/{$id}");
        return $response->json();
    }

    /**
     * Delete a book by ID.
     *
     * @param int $id
     * @return array
     */
    public function deleteBook($id)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['error' => 'Unauthorized: No API token found.'];

        $response = Http::withToken($accessToken)->delete("{$this->apiUrl}/books/{$id}");
        return $response->json();
    }
}
