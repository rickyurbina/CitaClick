@extends('layouts.cliente')

@section('page_title', 'Catálogo de Soluciones')

@section('content')
    <section class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="max-w-2xl">
                <h1 class="font-headline-lg md:font-headline-xl text-headline-lg-mobile md:text-headline-xl text-primary mb-4">Enterprise Solutions Catalog</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant">Strategic infrastructure and security services designed for the modern corporate landscape. Scale with confidence.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="pl-10 pr-4 py-2 bg-surface border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all w-full md:w-64 font-body-sm text-body-sm" placeholder="Search solutions..." type="text">
                </div>
                <button class="flex items-center gap-2 border-[1.5px] border-[#0F172A] text-[#0F172A] px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    Filter
                </button>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-8">
            <span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-[4px] font-label-sm text-label-sm">All Services</span>
            <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Cloud Security</span>
            <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Risk Management</span>
            <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Network Audit</span>
            <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Compliance</span>
        </div>
    </section>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-lg">
        <div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
            <div class="relative h-64 w-full overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRa6aBbgUq24NcGofPuxRoLuQoN0nnfKlm3kUK8djoWLlGMLDwTjRiPGCHmfQM8MB4XbkwK8Vn0lPH_3vjZRau7zyoqTnec9tZ84ple8IDA752e0ZrayNjn_URwceX3_PbYgaHsJuhwexjVXsXrHNQ5BFGDT20nGslOgDQbRwDRA9AwIiHZB0NwuO2E29O5n5-ltlu18RdKdflG_H6w8jRP_57MlsfPpHz4JN25thP5zjIHeomd7xDFg" alt="Cyber Guard Core">
                <div class="absolute top-4 right-4 px-2 py-1 bg-secondary-container/90 backdrop-blur-sm text-on-secondary-container text-[10px] font-bold uppercase tracking-wider rounded">Featured</div>
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-headline-md text-headline-md text-primary">Cyber Guard Core</h3>
                    <span class="font-label-md text-label-md text-secondary">$1,200/mo</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Integrated endpoint protection and 24/7 threat monitoring for medium to large enterprise networks. Includes weekly vulnerability assessments.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
                    <button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
                </div>
            </div>
        </div>
        <!-- Repetir para más productos... -->
    </div>

    <div class="mt-16 flex justify-center">
        <button class="flex items-center gap-2 border-[1.5px] border-[#0F172A] text-[#0F172A] px-8 py-3 rounded-lg font-label-md text-label-md hover:bg-surface-container-high transition-all active:scale-95">
            Load More Solutions
            <span class="material-symbols-outlined">expand_more</span>
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', function(e) { this.style.opacity = '0.8'; });
            button.addEventListener('mouseup', function(e) { this.style.opacity = '1'; });
            button.addEventListener('mouseleave', function(e) { this.style.opacity = '1'; });
        });
    </script>
@endpush

@push('styles')
    <style>
        .product-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.1);
        }
    </style>
@endpush