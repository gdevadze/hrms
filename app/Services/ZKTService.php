<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Log;

class ZKTService {
    protected $client;
    protected $jar;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://212.58.113.4:12000/',
        ]);

        // Create a CookieJar instance to store session cookies
        $this->jar = new CookieJar();
    }

    public function login($username, $password)
    {
        try {
            // Make a POST request to the login endpoint
            $response = $this->client->post('bioLogin.do', [
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                ],
                'cookies' => $this->jar, // Store cookies
            ]);

            // Log the response
            Log::info('Login Response:', [
                'status' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getAttendanceData($startDate, $endDate)
    {
        try {
            // Make the GET request using the session cookies obtained from login
            $response = $this->client->get('api/attendance', [
                'query' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
                'cookies' => $this->jar, // Send cookies with the request
            ]);

            // Log the response
            Log::info('Attendance Data Response:', [
                'status' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Attendance Data Error: ' . $e->getMessage());
            return false;
        }
    }

}
