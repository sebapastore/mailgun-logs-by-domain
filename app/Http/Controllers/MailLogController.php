<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class MailLogController extends Controller
{
    public function index(Request $request){
        $domain = Domain::find($request->domain_id);
        $client = new Client(['base_uri' => 'https://api.mailgun.net/','timeout'  => 10.0]);
        $method = 'GET';
        $uri = 'v3/'.$domain->name.'/events';
        $date = Carbon::today()->toRfc2822String();//todo:verify timezone - date example:Thu, 17 March 2022 19:00:00 -0000'
        $body = array(
            'begin' => $date,
            'limit' => '10',
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
        $jsonResponse = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() == "200") {
            return $jsonResponse->items;
        }
    }
}
