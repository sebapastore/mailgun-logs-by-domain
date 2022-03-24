<?php

namespace App\Http\Controllers;

use App\Helpers\FlashBannerHelper;
use App\Models\MailLog;
use Carbon\Carbon;
use Inertia\Inertia;

class MailLogController extends Controller
{
    public function index()
    {
        $domainId = request()->domain_id;

        $user = request()->user();

        if($domainId && !$user->canAccessDomainData($domainId)) {
            abort(403);
        }

        $filters = request()->only(['domain_id', 'search']);
        $filters['date_from'] = request()->date_from ?: Carbon::now()->format('Y-m-d');
        $filters['date_to'] = request()->date_to ?: Carbon::now()->format('Y-m-d');

        $logs = MailLog::query()
            ->where('domain_id', $domainId)
            ->whereBetween('timestamp', [$filters['date_from'], $filters['date_to']])
            ->when(request()->input('event'), function($q, $event) {
                $q->where('event', $event);
            })
            ->when(request()->input('search'), function($q, $search) {
                $q->where(function($q) use ($search) {
                    $q->whereLike('message_to', $search)
                        ->orWhereLike('subject', $search);
                });
            })
            ->orderByDesc('timestamp')
            ->paginate(15)
            ->withQueryString();

        $domains = $user->getDomainsForSelect();

        $events = MailLog::getEventsForSelect();

        return Inertia::render('MailLogs/List', [
            'logs' => $logs,
            'filters' => $filters,
            'domains' => $domains,
            'events' => $events,
        ]);
    }

}
