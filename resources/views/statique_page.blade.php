@extends('layouts.base')
@section('content')

@section('pageTitle')
    {{ $page->slug }}
@endsection

@section('extraStyle')
    <style>
        h1 {
            font-size: 40px;
            font-family: 'DM serif';
            color: var(--color-green-gs);
            text-align: center;
            padding: 20px 0;
            font-weight: bold;
        }

        h2 {
            font-size: 30px;
            font-family: 'DM serif';
            font-weight: bold;
            padding: 10px 0;
        }

        h3 {
            font-size: 24px;
            font-family: 'DM serif';
            font-weight: bold;
            padding: 8px 0;
        }

        h4.elementor-toc__header-title {
            display: none;
        }

        .content a {
            color: var(--color-green-gs);
        }

        .content a:hover {
            color: #e9d168;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Transition pour l'accordéon */
        .accordion-content {
            transition: max-height 0.3s ease-out, opacity 0.2s ease;
        }

        /* Indentation pour les sous-sections */
        .toc-level-2 {
            padding-left: 1rem;
            border-left: 2px solid #e2e8f0;
            margin-left: 0.5rem;
        }
    </style>
@endsection

<div class="bg-green-gs/50 content w-full py-10 font-roboto-slab"
    style="background: url('images/Fond-page-politique.jpg') center center /cover">
    <div class="w-full bg-white p-5 lg:mx-auto lg:w-[70%] font-roboto-slab">
        <h1 class="font-roboto-slab text-green-gs py-2 text-center text-7xl font-bold">{{ $page->title }}</h1>

        <!-- Table des matières - Accordéon -->
        <div x-data="{
            open: true,
            sections: [],
            generateTOC() {
                setTimeout(() => {
                    const contentElement = document.querySelector('.content');
                    if (!contentElement) return;
        
                    // Récupérer tous les H1 et H2
                    const headings = contentElement.querySelectorAll('h2, h3');
                    let currentH1 = null;
                    const tocSections = [];
        
                    headings.forEach((heading, index) => {
                        if (!heading.id) {
                            heading.id = 'section-' + index;
                        }
        
                        if (heading.tagName === 'H2') {
                            currentH1 = {
                                id: heading.id,
                                text: heading.textContent.trim(),
                                children: []
                            };
                            tocSections.push(currentH1);
                        } else if (heading.tagName === 'H3' && currentH1) {
                            currentH1.children.push({
                                id: heading.id,
                                text: heading.textContent.trim()
                            });
                        }
                    });
        
                    this.sections = tocSections;
                }, 100);
                }
            }" x-init="generateTOC()" class="mb-10">
            <div class="overflow-hidden rounded-lg border border-gray-200 bg-gray-50 font-roboto-slab">
                <button @click="open = !open"
                    class="text-green-gs flex w-full items-center justify-between px-6 py-4 text-left font-medium transition-colors duration-200 hover:bg-gray-100"
                    :aria-expanded="open">
                    <span class="font-roboto-slab text-xl font-bold">Table des matières</span>
                    <svg class="h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="accordion-content px-6 pb-4">
                    <nav aria-label="Table des matières">
                        <ul class="space-y-2">
                            <template x-for="(section, index) in sections" :key="index">
                                <li class="space-y-2">
                                    <a :href="'#' + section.id"
                                        class="text-green-gs block py-2 font-medium transition-colors duration-200 hover:text-green-700 hover:underline"
                                        x-text="section.text"></a>

                                    <ul x-show="section.children.length > 0" class="toc-level-2 space-y-1">
                                        <template x-for="(subsection, subIndex) in section.children"
                                            :key="subIndex">
                                            <li>
                                                <a :href="'#' + subsection.id"
                                                    class="block py-1 text-gray-700 transition-colors duration-200 hover:text-green-700 hover:underline"
                                                    x-text="subsection.text"></a>
                                            </li>
                                        </template>
                                    </ul>
                                </li>
                            </template>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        {!! $page->content !!}
    </div>
</div>

@stop
