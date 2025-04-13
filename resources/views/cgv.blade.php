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

<div class="w-full bg-green-gs/50 py-10 content"
    style="background: url('images/Fond-page-politique.jpg') center center /cover">
    <div class="w-full lg:w-[70%] lg:mx-auto p-5 bg-white">
        <h1 class="text-7xl font-dm-serif font-bold text-green-gs text-center py-2">{{ $page->title }}</h1>

        <!-- Table des matières - Accordéon -->
        <div x-data="{
            open: true,
            sections: [],
            generateTOC() {
                setTimeout(() => {
                    const contentElement = document.querySelector('.content');
                    if (!contentElement) return;
        
                    // Récupérer tous les H1 et H2
                    const headings = contentElement.querySelectorAll('h1, h2');
                    let currentH1 = null;
                    const tocSections = [];
        
                    headings.forEach((heading, index) => {
                        if (!heading.id) {
                            heading.id = 'section-' + index;
                        }
        
                        if (heading.tagName === 'H1') {
                            currentH1 = {
                                id: heading.id,
                                text: heading.textContent.trim(),
                                children: []
                            };
                            tocSections.push(currentH1);
                        } else if (heading.tagName === 'H2' && currentH1) {
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
            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                <button @click="open = !open"
                    class="w-full px-6 py-4 flex justify-between items-center text-left font-medium text-green-gs hover:bg-gray-100 transition-colors duration-200"
                    :aria-expanded="open">
                    <span class="text-xl font-dm-serif font-bold">Table des matières</span>
                    <svg class="w-5 h-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }"
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
                                        class="block py-2 font-medium text-green-gs hover:text-green-700 hover:underline transition-colors duration-200"
                                        x-text="section.text"></a>

                                    <ul x-show="section.children.length > 0" class="toc-level-2 space-y-1">
                                        <template x-for="(subsection, subIndex) in section.children"
                                            :key="subIndex">
                                            <li>
                                                <a :href="'#' + subsection.id"
                                                    class="block py-1 text-gray-700 hover:text-green-700 hover:underline transition-colors duration-200"
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
