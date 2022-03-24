<?php

namespace App\Http\Controllers;

use App\Helpers\FlashBannerHelper;
use App\Models\MailLog;
use Illuminate\Http\Request;
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

        $domains = $user->getDomainsForSelect();

        $logs = MailLog::query()
            ->where('domain_id', $domainId)
            ->when(request()->input('search'), function($q, $search) {
                $q->where(function($q) use ($search) {
                    $q->whereLike('message_to', $search)
                        ->orWhereLike('subject', $search);
                });
            })
            ->orderByDesc('timestamp')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('MailLogs/List', [
            'logs' => $logs,
            'filters' => request()->only('search', 'domain_id'),
            'domains' => $domains,
        ]);
    }

}
