<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Domain;

class FetchMailsFromAPIService
{
    protected $domain;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    public function get()
    {
        #1- Get Logs from API
        $client = new Client(['base_uri' => 'https://api.mailgun.net/','timeout'  => 10.0]);
        $method = 'GET';
        $uri = 'v3/'.$this->domain->name.'/events';
        $now= Carbon::now()->toRfc2822String();//todo:verify timezone - date example:Thu, 17 March 2022 19:00:00 -0000'
        $before  = Carbon::now()->subMinutes(360)->toRfc2822String();//todo:verify timezone - date example:Thu, 17 March 2022 19:00:00 -0000'
        $body = array(
            'begin' => $before,
            'end' => $now,
            'limit' => '300',//max limit from mailgun
            'pretty' => 'yes',
            'ascending' => 'yes'
        );
        $response = $client->request(
                $method,
                $uri,
                [
                    'auth' => ['api',env('MAILGUN_API_KEY')],
                    'query' => $body,
                ]);
        if ($response->getStatusCode() == "200") {
            return json_decode($response->getBody()->getContents());
        }
        else {
            return null;
        }
    }
}