<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function index(): View
    {
        $subscribers = NewsletterSubscriber::query()
            ->latest()
            ->paginate(25);

        return view('newsletter.index', [
            'subscribers' => $subscribers,
        ]);
    }

    public function store(StoreNewsletterSubscriberRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->create($request->validated());

        return redirect()
            ->route('shop')
            ->with('success', 'Your email has been saved.');
    }
}
