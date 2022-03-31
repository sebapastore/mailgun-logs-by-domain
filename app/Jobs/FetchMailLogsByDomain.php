<?php

namespace App\Jobs;

use App\Models\MailLog;
use App\Models\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use GuzzleHttp\Client;

class FetchMailLogsByDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $domain;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
        $jsonResponse = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() == "200") {
            #2- Save Logs on DB
            $items = $jsonResponse->items;
            foreach ($items as $item) {
                $headers = $item->message->headers;
                #Check if Log already exists on DB
                $mailLogExist = MailLog::where('mailgun_id',$item->id)->first();
                if ($mailLogExist == null) {
                    MailLog::create([
                        'domain_id' => $this->domain->id,
                        'mailgun_id' => $item->id,
                        'event' => $item->event,
                        'message_to' => $item->recipient,
                        'message_from' => $headers->from,
                        'subject' => $headers->subject,
                        'timestamp' => gmdate("Y-m-d H:i:s", $item->timestamp),
                        'data' => json_encode("{}")//todo,
                    ]);
                }
            }
        }        
    }
}
