@extends('layouts.website')

@section('title', 'Frequently Asked Questions')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/faq.css') }}">
@endsection

@section('content')

    {{-- =========================================================
    FAQ HERO
    ========================================================= --}}

    <section class="faq-hero">

        <div class="faq-container">

            <span class="faq-badge">
                <i class="bi bi-question-circle"></i>
                FAQ
            </span>

            <h1>
                Frequently Asked
                <span>Questions</span>
            </h1>

            <p>
                Find simple answers to the most common questions
                about our platform, packages and membership journey.
            </p>

            <div class="faq-search">

                <i class="bi bi-search"></i>

                <input type="text" id="faqSearch" placeholder="Search your question..." autocomplete="off">

            </div>

        </div>

    </section>


    {{-- =========================================================
    FAQ CONTENT
    ========================================================= --}}

    <section class="faq-section">

        <div class="faq-container">

            <div class="faq-layout">

                {{-- LEFT --}}
                <div class="faq-sidebar">

                    <div class="faq-sidebar-card">

                        <div class="faq-sidebar-icon">
                            <i class="bi bi-headset"></i>
                        </div>

                        <span>
                            NEED HELP?
                        </span>

                        <h3>
                            Can't find your answer?
                        </h3>

                        <p>
                            Explore our packages or get started
                            with your mobile number.
                        </p>

                        <a href="{{ route('packages') }}">
                            Explore Packages
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>


                    <div class="faq-quick-card">

                        <div class="faq-quick-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div>
                            <strong>
                                Package Questions
                            </strong>

                            <span>
                                View complete package details
                            </span>
                        </div>

                    </div>

                </div>


                {{-- RIGHT --}}
                <div class="faq-list-wrapper">

                    <div class="faq-list">

                        @foreach($faqs as $index => $faq)

                            <div class="faq-item" data-question="{{ strtolower($faq['question']) }}"
                                data-answer="{{ strtolower($faq['answer']) }}">

                                <button type="button" class="faq-question">

                                    <span class="faq-number">
                                        {{ sprintf('%02d', $index + 1) }}
                                    </span>

                                    <span class="faq-question-text">
                                        {{ $faq['question'] }}
                                    </span>

                                    <span class="faq-toggle">
                                        <i class="bi bi-plus"></i>
                                    </span>

                                </button>

                                <div class="faq-answer">

                                    <div class="faq-answer-inner">
                                        {{ $faq['answer'] }}
                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <div id="faqNoResults" class="faq-no-results" style="display:none;">

                        <div>
                            <i class="bi bi-search"></i>
                        </div>

                        <h3>
                            No questions found
                        </h3>

                        <p>
                            Try searching with a different keyword.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    CTA
    ========================================================= --}}

    <section class="faq-cta">

        <div class="faq-container">

            <div class="faq-cta-box">

                <div>

                    <span>
                        READY TO START?
                    </span>

                    <h2>
                        Still have questions?
                        <strong>Start your journey.</strong>
                    </h2>

                    <p>
                        Explore our packages and discover how
                        the platform works.
                    </p>

                </div>

                <div class="faq-cta-buttons">

                    <a href="{{ route('packages') }}" class="faq-white-btn">
                        View Packages
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="{{ route('login') }}" class="faq-outline-btn">
                        Get Started
                    </a>

                </div>

            </div>

        </div>

    </section>


@endsection


@section('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const faqItems = document.querySelectorAll('.faq-item');
            const searchInput = document.getElementById('faqSearch');
            const noResults = document.getElementById('faqNoResults');


            /*
            |--------------------------------------------------------------------------
            | FAQ Accordion
            |--------------------------------------------------------------------------
            */

            faqItems.forEach(function (item) {

                const button = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');

                button.addEventListener('click', function () {

                    const isOpen = item.classList.contains('active');


                    // Close all
                    faqItems.forEach(function (otherItem) {

                        otherItem.classList.remove('active');

                        const otherAnswer =
                            otherItem.querySelector('.faq-answer');

                        otherAnswer.style.maxHeight = null;

                    });


                    // Open selected
                    if (!isOpen) {

                        item.classList.add('active');

                        answer.style.maxHeight =
                            answer.scrollHeight + 'px';

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | FAQ Search
            |--------------------------------------------------------------------------
            */

            searchInput.addEventListener('input', function () {

                const search = this.value
                    .toLowerCase()
                    .trim();

                let visibleCount = 0;


                faqItems.forEach(function (item) {

                    const question =
                        item.dataset.question || '';

                    const answer =
                        item.dataset.answer || '';


                    if (
                        question.includes(search) ||
                        answer.includes(search)
                    ) {

                        item.style.display = '';

                        visibleCount++;

                    } else {

                        item.style.display = 'none';

                    }

                });


                if (visibleCount === 0 && search !== '') {

                    noResults.style.display = 'block';

                } else {

                    noResults.style.display = 'none';

                }

            });

        });

    </script>

@endsection