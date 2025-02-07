<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CandidateApiService;
use Illuminate\Support\Facades\Session;



class CreateAuthorCommand extends Command
{
    protected $signature = 'author:create author:create';
    protected $description = 'Create a new author via API';
    private $candidateApi;

    public function __construct(CandidateApiService $candidateApi)
    {
        parent::__construct();
        $this->candidateApi = $candidateApi;    
    }

    public function handle()
    {
        $firstName = $this->ask('first_name');
        $lastName = $this->ask('last_name');
        $birthday = "2025-02-07T20:28:18.241Z";
        $biography = $this->ask('biography');
        $gender = $this->choice('Select Gender', ['male', 'female'], 1);
        $placeOfBirth = $this->ask('place_of_birth');

        $getToken = $this->candidateApi->login();

        Session::put('access_token', $getToken['token_key']);


        // Call the service
        $response = $this->candidateApi->createAuthor($firstName, $lastName, $birthday, $biography, $gender, $placeOfBirth);

        // Output the result
        if (!$response['success']) {
            $this->error($response['message']);
            return Command::FAILURE;
        }

        $this->info($response['message']);
        return Command::SUCCESS;
    }
}
