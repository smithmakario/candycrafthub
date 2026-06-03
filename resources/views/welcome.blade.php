@extends('layouts.marketing')

@section('title', 'Mystery Box | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')
    @include('welcome.partials.hero')
    @include('welcome.partials.how-it-works')
    @include('welcome.partials.plans')
    @include('welcome.partials.sneak-peek')
    @include('welcome.partials.testimonials')
    @include('welcome.partials.quiz')
    @include('welcome.partials.faq')
    @include('marketing.partials.footer')
@endsection
