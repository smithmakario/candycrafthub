<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Newsletter',
        'subtitle' => 'Email addresses collected from the shop signup form.',
    ])

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[480px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Email</th>
                    <th class="px-md py-sm align-middle">Subscribed</th>
                </tr>
            </thead>
            <tbody class="text-body-md">
                @forelse ($subscribers as $subscriber)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle font-medium">{{ $subscriber->email }}</td>
                        <td class="px-md py-md align-middle text-on-surface-variant">
                            {{ $subscriber->created_at->format('M j, Y g:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-md py-xl text-center text-on-surface-variant">
                            No newsletter signups yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($subscribers->hasPages())
        <div class="mt-md">{{ $subscribers->links() }}</div>
    @endif
</x-app-layout>
