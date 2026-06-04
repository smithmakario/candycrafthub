@php
    $toastMessage = session('success') ?? session('error') ?? ($errors->any() ? $errors->first() : null);
    $toastType = session('success') ? 'success' : (session('error') || $errors->any() ? 'error' : null);
@endphp

@if ($toastMessage && $toastType)
    <div
        id="marketing-toast"
        role="alert"
        aria-live="polite"
        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] w-[calc(100%-2rem)] max-w-md pointer-events-auto opacity-0 translate-y-4 transition-all duration-300 ease-out"
        data-toast-type="{{ $toastType }}"
    >
        <div @class([
            'flex items-start gap-sm rounded-xl px-md py-sm shadow-lg border',
            'bg-primary-container text-on-primary-container border-primary/20' => $toastType === 'success',
            'bg-error-container text-on-error-container border-error/20' => $toastType === 'error',
        ])>
            <span class="material-symbols-outlined shrink-0 mt-0.5" data-icon="{{ $toastType === 'success' ? 'check_circle' : 'error' }}">
                {{ $toastType === 'success' ? 'check_circle' : 'error' }}
            </span>
            <p class="flex-1 font-label-md text-left">{{ $toastMessage }}</p>
            <button
                type="button"
                id="marketing-toast-dismiss"
                class="shrink-0 rounded-full p-xs hover:bg-black/5 transition-colors"
                aria-label="Dismiss notification"
            >
                <span class="material-symbols-outlined text-[20px]" data-icon="close">close</span>
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            (() => {
                const toast = document.getElementById('marketing-toast');
                if (!toast) {
                    return;
                }

                const dismiss = () => {
                    toast.classList.add('opacity-0', 'translate-y-4');
                    toast.addEventListener('transitionend', () => toast.remove(), { once: true });
                };

                requestAnimationFrame(() => {
                    toast.classList.remove('opacity-0', 'translate-y-4');
                });

                document.getElementById('marketing-toast-dismiss')?.addEventListener('click', dismiss);
                window.setTimeout(dismiss, 5000);
            })();
        </script>
    @endpush
@endif
