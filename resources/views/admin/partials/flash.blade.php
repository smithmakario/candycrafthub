@if (session('success'))
    <div class="mb-md rounded-xl bg-secondary-container text-on-secondary-container px-md py-sm text-label-md">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-md rounded-xl bg-error-container text-on-error-container px-md py-sm text-label-md">
        <ul class="list-disc list-inside space-y-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
