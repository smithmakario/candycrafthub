@extends('layouts.marketing')

@section('title', 'Contact Us | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="relative mt-20">
        <!-- Floating Elements Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
            <div class="candy-float absolute top-20 left-10 opacity-20 text-primary-container scale-150">
                <span class="material-symbols-outlined text-[80px]" data-icon="lollipop">loop</span>
            </div>
            <div class="candy-float absolute top-1/2 right-10 opacity-20 text-secondary-container scale-150"
                style="animation-delay: 2s;">
                <span class="material-symbols-outlined text-[100px]" data-icon="ice_cream">icecream</span>
            </div>
            <div class="candy-float absolute bottom-20 left-1/4 opacity-20 text-tertiary-container scale-125"
                style="animation-delay: 4s;">
                <span class="material-symbols-outlined text-[70px]" data-icon="cookie">cookie</span>
            </div>
        </div>
        <!-- Hero Section -->
        <section class="relative z-10 px-margin-mobile md:px-margin-desktop pt-xl pb-lg max-w-7xl mx-auto text-center">
            <h1
                class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-md">
                Say Hello to Sweetness</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                Whether you're battling a sudden candy craving, planning the ultimate Lagos celebration, or just want to
                share some sugar-coated feedback, we're here to sprinkle some magic on your day.
            </p>
        </section>
        <!-- Contact Grid -->
        <section class="relative z-10 px-margin-mobile md:px-margin-desktop pb-xl max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
                <!-- Contact Form Card -->
                <div
                    class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-md md:p-lg shadow-sm border border-outline-variant/10"
                    id="contact-form">
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-lg">Send Us a Message</h2>
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-md">
                        @csrf
                        @if ($errors->any())
                            <div class="rounded-xl bg-error-container text-on-error-container px-md py-sm text-label-md">
                                <ul class="list-disc list-inside space-y-xs">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="space-y-xs">
                                <label class="font-label-md text-label-md text-on-surface-variant ml-xs" for="contact-name">Your Name</label>
                                <input
                                    id="contact-name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="w-full rounded-full border-2 border-outline-variant/30 bg-surface-bright px-md py-sm focus:border-secondary focus:ring-0 transition-colors @error('name') border-error @enderror"
                                    placeholder="Abigail Chukwu"
                                    type="text" />
                            </div>
                            <div class="space-y-xs">
                                <label class="font-label-md text-label-md text-on-surface-variant ml-xs" for="contact-email">Email
                                    Address</label>
                                <input
                                    id="contact-email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full rounded-full border-2 border-outline-variant/30 bg-surface-bright px-md py-sm focus:border-secondary focus:ring-0 transition-colors @error('email') border-error @enderror"
                                    placeholder="hello@example.com"
                                    type="email" />
                            </div>
                        </div>
                        <div class="space-y-xs">
                            <label class="font-label-md text-label-md text-on-surface-variant ml-xs" for="contact-subject">Subject</label>
                            <select
                                id="contact-subject"
                                name="subject"
                                required
                                class="w-full rounded-full border-2 border-outline-variant/30 bg-surface-bright px-md py-sm focus:border-secondary focus:ring-0 transition-colors appearance-none @error('subject') border-error @enderror">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->value }}" @selected(old('subject') === $subject->value)>
                                        {{ $subject->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-xs">
                            <label class="font-label-md text-label-md text-on-surface-variant ml-xs" for="contact-message">Your Message</label>
                            <textarea
                                id="contact-message"
                                name="message"
                                required
                                class="w-full rounded-lg border-2 border-outline-variant/30 bg-surface-bright px-md py-sm focus:border-secondary focus:ring-0 transition-colors @error('message') border-error @enderror"
                                placeholder="Tell us what's on your mind..."
                                rows="5">{{ old('message') }}</textarea>
                        </div>
                        <button
                            class="w-full md:w-auto px-xl py-sm bg-primary-container text-on-primary-container font-label-md text-label-md rounded-full shadow-sm hover:scale-105 active:scale-95 transition-all duration-200 flex items-center justify-center gap-sm"
                            type="submit">
                            Send Magic <span class="material-symbols-outlined text-[20px]"
                                data-icon="auto_fix_high">auto_fix_high</span>
                        </button>
                    </form>
                </div>
                <!-- Lagos Presence Sidebar -->
                <div class="lg:col-span-5 flex flex-col gap-gutter">
                    <!-- HQ Card -->
                    <div class="glass-card rounded-xl p-md md:p-lg">
                        <div class="flex items-start gap-md mb-md">
                            <div
                                class="w-12 h-12 bg-secondary-container rounded-full flex items-center justify-center text-on-secondary-container">
                                <span class="material-symbols-outlined" data-icon="location_on">location_on</span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface">Lagos HQ</h3>
                                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                                    Admiralty Way, In the heart of Lekki Phase 1, Lagos.</p>
                            </div>
                        </div>
                        <div class="w-full h-48 rounded-lg overflow-hidden relative group">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                data-alt="A cinematic, high-angle photograph of a premium, boutique candy shop in Lekki, Lagos. The shop features bright pastel pink and gold accents, with expansive glass windows reflecting the tropical Nigerian sun. The atmosphere is upscale yet playful, with lush greenery nearby and a clear blue sky above. The lighting is warm and golden, emphasizing the premium craft nature of the confectionery."
                                data-location="Lagos, Nigeria"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuADVAzs3jOA4tcsuNuCprKE0pru_Vjq0tKd0BzK-ztSnzIId2KUGahtrgto07aGYdzRhUSoFPUYM75mUUUlyN_Pu6PuDKZJ9B8on5vAZmpfXxWnEUN7GpSudfUptzo0vyEjoNvNt4V4qtUcFbuIKnO2NNdmZD1rmyxjSynDlBr6M9vT-Gqh1xvCnOcraDuDyeqNk73pL7ALeIcSjZl_K1MkjRWJdJ5aVwTqZY_phB2KcEbphWytIWnzW1jPm7X3BOrWPdCKkgpSq-AM" />
                            <div
                                class="absolute inset-0 bg-primary/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span
                                    class="bg-surface px-md py-xs rounded-full font-label-sm text-label-sm text-primary">Open
                                    in Maps</span>
                            </div>
                        </div>
                    </div>
                    <!-- Rapid Response -->
                    <div class="bg-surface-container-high rounded-xl p-md md:p-lg space-y-md">
                        <div class="flex items-center gap-md">
                            <span class="material-symbols-outlined text-secondary" data-icon="chat">chat</span>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant">Phone &amp; WhatsApp</p>
                                <p class="font-body-lg text-body-lg text-on-surface font-semibold">+234 913 750 0141</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-md">
                            <span class="material-symbols-outlined text-secondary" data-icon="mail">mail</span>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant">General Sweets</p>
                                <p class="font-body-lg text-body-lg text-on-surface font-semibold">customercare@candycrafthub.com</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-md">
                            <span class="material-symbols-outlined text-secondary"
                                data-icon="event_available">event_available</span>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant">Event Inquiries</p>
                                <p class="font-body-lg text-body-lg text-on-surface font-semibold">enquiry@candycrafthub.com</p>
                            </div>
                        </div>
                    </div>
                    <!-- Hours -->
                    <div class="bg-tertiary-container/20 rounded-xl p-md md:p-lg border border-tertiary-container/30">
                        <h4 class="font-label-md text-label-md text-on-tertiary-container mb-sm flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]" data-icon="schedule">schedule</span> Candy
                            Kitchen Hours
                        </h4>
                        <div class="flex justify-between font-body-md text-body-md text-on-surface mb-xs">
                            <span>Mon - Sat</span>
                            <span class="font-bold">9:00 AM - 7:00 PM</span>
                        </div>
                        <div class="flex justify-between font-body-md text-body-md text-on-surface">
                            <span>Sundays</span>
                            <span class="font-bold">12:00 PM - 5:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sweet Solutions (FAQ) -->
        <section class="bg-surface-container-low py-xl">
            <div class="px-margin-mobile md:px-margin-desktop max-w-4xl mx-auto">
                <div class="text-center mb-lg">
                    <h2 class="font-headline-md text-headline-md text-primary mb-xs">Sweet Solutions</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Quick answers to satisfy your curiosity.
                    </p>
                </div>
                <div class="space-y-md">
                    <!-- FAQ 1 -->
                    <details
                        class="group bg-surface-bright rounded-lg shadow-sm border border-outline-variant/10 overflow-hidden cursor-pointer">
                        <summary class="flex justify-between items-center p-md list-none focus:outline-none">
                            <span class="font-label-md text-label-md text-on-surface">Where do you deliver?</span>
                            <span class="material-symbols-outlined group-open:rotate-180 transition-transform text-primary"
                                data-icon="expand_more">expand_more</span>
                        </summary>
                        <div class="px-md pb-md font-body-md text-body-md text-on-surface-variant">
                            We currently sprinkle magic across all areas of Lagos, from Lekki to Ikeja! We offer same-day
                            delivery for orders placed before 12 PM. Nationwide shipping for non-perishable treats is coming
                            soon.
                        </div>
                    </details>
                    <!-- FAQ 2 -->
                    <details
                        class="group bg-surface-bright rounded-lg shadow-sm border border-outline-variant/10 overflow-hidden cursor-pointer">
                        <summary class="flex justify-between items-center p-md list-none focus:outline-none">
                            <span class="font-label-md text-label-md text-on-surface">Can I customize a box?</span>
                            <span class="material-symbols-outlined group-open:rotate-180 transition-transform text-primary"
                                data-icon="expand_more">expand_more</span>
                        </summary>
                        <div class="px-md pb-md font-body-md text-body-md text-on-surface-variant">
                            Absolutely! Our "Craft Your Own" section allows you to pick every single treat. For corporate
                            gifts or large weddings, our design team can even customize packaging with your branding.
                        </div>
                    </details>
                    <!-- FAQ 3 -->
                    <details
                        class="group bg-surface-bright rounded-lg shadow-sm border border-outline-variant/10 overflow-hidden cursor-pointer">
                        <summary class="flex justify-between items-center p-md list-none focus:outline-none">
                            <span class="font-label-md text-label-md text-on-surface">How early should I book an
                                event?</span>
                            <span class="material-symbols-outlined group-open:rotate-180 transition-transform text-primary"
                                data-icon="expand_more">expand_more</span>
                        </summary>
                        <div class="px-md pb-md font-body-md text-body-md text-on-surface-variant">
                            For signature candy bars and event services, we recommend booking at least 3 weeks in advance to
                            ensure availability and proper curation. However, we do love a good challenge—feel free to reach
                            out for last-minute requests!
                        </div>
                    </details>
                </div>
            </div>
        </section>
        <!-- Social Section -->
        <section class="py-xl px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto text-center">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-lg">Follow the Sugar Trail</h2>
            <div class="flex justify-center gap-lg">
                <a class="group flex flex-col items-center gap-sm" href="https://www.instagram.com/candycrafthub/">
                    <div
                        class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                        <span class="material-symbols-outlined text-on-secondary-container text-[32px]"
                            data-icon="camera_alt">camera_alt</span>
                    </div>
                    <span
                        class="font-label-md text-label-md text-on-surface-variant group-hover:text-primary transition-colors">Instagram</span>
                </a>
                <a class="group flex flex-col items-center gap-sm" href="https://www.facebook.com/Candycrafthub/">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-container flex items-center justify-center group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                        <span class="material-symbols-outlined text-on-primary-container text-[32px]"
                            data-icon="public">public</span>
                    </div>
                    <span
                        class="font-label-md text-label-md text-on-surface-variant group-hover:text-primary transition-colors">Facebook</span>
                </a>
            </div>
            <div class="mt-xl grid grid-cols-2 md:grid-cols-4 gap-sm">
                <div class="aspect-square rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                        data-alt="A close-up, high-detail macro photograph of artisanal gummy candies with vibrant colors and sugar crystals. The lighting is soft and bright, creating a cheerful, playful mood. The colors are dominated by soft pinks and sky blues, perfectly matching a premium whimsical brand aesthetic. Depth of field is shallow, focusing on the texture of the sweets."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuChZzjwqbbgGcKPUQKU-jJZtNvixcpxkeSXt85dIqZcaDpw2tSsifvWkwAMnIOZWays8Eva3agZHlYRo3T5ldTQNOu2HzLTfrbZiVVCTH3hVnb6BbmO9cKJoXPvCcOaBBg0n5x6CL3R-9sQATQsmIt0a5OEMGmComLlw3yDIOrXtrfS21udLBcHbZCx0JZzg12a6C0iVTwM6aCTFGRotKf9te4mCOWJXSaFBSzP9FKdccgIelyBCNJa1SJskcR6gNXCei1B5vbSakZV" />
                </div>
                <div class="aspect-square rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                        data-alt="A beautifully curated candy bar at an upscale Lagos garden party. The scene features crystal jars filled with assorted premium sweets, decorated with soft pink ribbons and sky blue floral arrangements. The background shows a soft-focus lush green garden under golden hour light, reflecting a sophisticated and celebratory atmosphere in a luxury setting."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQySqXpKohxTB6rS0ctG8pVmOPSFDSRbP1uiF-mkWgL5KjERt4LWReMnlj9zcBH1W0FTAkZl0Uc3lkY5jgbNhVO9Sc9lsR24a3rGsckOcyMm0_M8qLyJp41WLVAW2TzrHPZ176JXC-MRfdhcGApdQPT6E89nv2RZsPNPWGs8k-DxeGqFbgRke9emrTflIJOTeCfjcX3V85euXh91eEP6tjnR4Y6CJQoypKOckF8Oj9W6iUQjcUziq3uIr7VVQHbfyFUeN9xdV9KL-y" />
                </div>
                <div class="aspect-square rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                        data-alt="A premium gift box from Candy Craft Hub being opened by elegant hands. The box is a soft matte pink with gold foil lettering. Inside, meticulously arranged chocolates and candies sit in individual compartments. The scene is lit with bright, clean studio lighting, emphasizing the luxury and craftsmanship of the product."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCK19z5W0AVPt2vl2EGlzJJLcMqHQVdTXlSVUio6J_jqb7ICchXgMwpb-DgFBTegoqFVzkPEpQdvfUhvoXArtmxqjv8A6MwW6LH2r5V9otKV2ldmacJQ26nOmtJGpznMyY3aq8c9oYYbOFtWc2KE-3_z8p40oiT-73zRw_cfLdQAujwnYyx7kXdkc9Qf7coYK6j9V_jF2Mt05oQ9ALT7w4dMe6DRNyYdnYsdaGRzf9jdFrYUr37qkIYx0W1kWaHi2RJ6YSowYkZ9VQU" />
                </div>
                <div class="aspect-square rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                        data-alt="A collection of colorful lollipops in various shapes and sizes arranged artistically on a white marble surface. The lighting is high-key and airy, with soft shadows. The overall aesthetic is minimalist and modern, highlighting the vibrant colors and glass-like clarity of the handmade candies."
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI32nL_1MxJ1FVyp3WbEauT5xu0pk8z8do-AzWAJ4_JyQgK67fBwqaEQJc4Ix8rj77enk4JT_aluzCuKKd-2zYQA6UkQDtyoO6HqSbWrjkYIU5qqAjwmj2CEFFU8NVCLQjdPfkvbnEaeTQNYFn9pKKOqCKr0QHEY-2PmCVtTE4mvoNF64R8CvN-kMm9RgiHRTxsy9BCUzqogvxdXjRiQEFhCB6JXCK7SSSf_yUVKRhsmczB1-Gcf7qjfhCC-289X9nPfv5gZhriWqu" />
                </div>
            </div>
        </section>
    </main>

    @include('marketing.partials.footer')

    @include('marketing.partials.toast')
@endsection
