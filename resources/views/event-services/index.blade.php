@extends('layouts.marketing')

@section('title', 'Event Services | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="pt-xl">
        @include('event-services.partials.hero')
        @include('event-services.partials.services')
        @include('event-services.partials.how-it-works')
        @include('event-services.partials.packages')
        @include('event-services.partials.gallery')
        @include('event-services.partials.testimonials')
        @include('event-services.partials.intake-form')
        @include('event-services.partials.faq')
    </main>

    @include('marketing.partials.footer')
@endsection

@push('scripts')
    @include('event-services.partials.intake-scripts')
@endpush
