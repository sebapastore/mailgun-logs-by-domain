<?php

namespace App\Jobs;

use App\Models\MailLog;
use App\Models\Domain;
use App\Services\FetchMailsFromAPIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $fetchMailsFromAPIService = new FetchMailsFromAPIService($this->domain);
        $jsonResponse = $fetchMailsFromAPIService->get();
        #2- Save Logs on DB
        if (isset($jsonResponse)) $this->saveLogs($jsonResponse->items);
    }

    private function saveLogs($items)
    {
        foreach ($items as $item) {
            $mailLogExist = MailLog::where('mailgun_id',$item->id)->first();
            if ($mailLogExist == null) $this->saveLog($item);
        }
    }

    private function saveLog($item)
    {
        $headers = $item->message->headers;
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
