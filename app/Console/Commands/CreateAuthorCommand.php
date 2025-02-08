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
        $email = $this->ask('Enter Email address:');
        $password = $this->ask('Enter Password:');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email format.');
            return;
        }

        $getToken = $this->candidateApi->login(['email'=>$email,'password'=>$password]);

        if (isset($getToken['error'])) {
            $this->error('Invalid email password');
            return;
        }

        $firstName = $this->ask('Please enter author first name:');
        $lastName = $this->ask('Please enter author last name');
        $birthday = "2025-02-07T20:28:18.241Z";
        $biography = $this->ask('Please enter biography');
        $gender = $this->choice('Select Gender', ['male', 'female'], 1);
        $placeOfBirth = $this->ask('Place of birth');
       
       

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
