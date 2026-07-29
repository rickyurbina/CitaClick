@extends('layouts.cliente')

@section('page_title', 'Catálogo de Soluciones')

@section('content')
    <!-- Hero / Header Section -->
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
        <!-- Product Card 1 -->
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

        <!-- Product Card 2 -->
        <div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
            <div class="relative h-64 w-full overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsyF5UeT50WVvK_sWf5Mb7dasmgK65URLC6Fg3kLeEjAkCXjMXKSv2hgSzL0xhZ5iwYyI_x3Ct1GWDIFKG6cRDOdfQl4X5n2CVjhKEdIHVayNh_VSPk_4-WR0UwJ_x0JnvVayLxtrVmZyNkmH4RQ2YjvE-HHaMUqpfR_CpCdomrEvRMhSCT8q3UuLdUFnD7I01JG-PLw88J1skxfnY6xPgcNQwyrqKczOB3tm4cpu39hwK_KzRPqctvA" alt="Biometric Suite">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-headline-md text-headline-md text-primary">Biometric Suite</h3>
                    <span class="font-label-md text-label-md text-secondary">$850/site</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Advanced multi-factor physical access controls featuring facial recognition and encrypted keycard support for restricted zones.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
                    <button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
                </div>
            </div>
        </div>

        <!-- Product Card 3 -->
        <div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
            <div class="relative h-64 w-full overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7Xp5KhqJM4_EAKTXUVVzarNUXvYEi2SyrzlhoAx43UmXvJgP622p-PADy2MMXaHpMmUkB4pK772VPQNEwZ-IE_SNoz8oBlq7MzqyCRluv27mc7KP0xet4KpJYJ-T_KQ92ya2Jv9q6JifECoGSyYlAcfdVtwF-z7Wp3J5ZqNeqEt84PKN5yhEKYgrv2HkfdXl-U7fhlcf1wplc3nRHVd_Ammyn6J7QGm4Hmb700fZiMphsLkwrnZr-_g" alt="Cloud Vault Plus">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-headline-md text-headline-md text-primary">Cloud Vault Plus</h3>
                    <span class="font-label-md text-label-md text-secondary">$450/TB</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Immutable backup storage with zero-knowledge encryption. Designed for critical data recovery and regulatory compliance auditing.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
                    <button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
                </div>
            </div>
        </div>

        <!-- Product Card 4 -->
        <div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
            <div class="relative h-64 w-full overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBpsQOd4WnI41_UZQPoOsGmgdE-dRKnbUZR1G1YVBNtXN-ClMRQEAFWe5rFZ3Jm3egAg1NnJJn8r4f5kCycraq4KB79oA4vkT3bUwLB62gdshwAM-2sRbGLX8IhRUVt1UNcqO2dhL7-NkGpMwgS9_Xfkb-66-2CqTqshmDMjOE6qkhnCe-yNzg6kIuTPM9EDN0gKNZSBQGAe-igJd_31g2ATujMIjBELIqIAJtSdiV6NcaCDopOpB1vmA" alt="Risk Intelligence">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-headline-md text-headline-md text-primary">Risk Intelligence</h3>
                    <span class="font-label-md text-label-md text-secondary">$2,100/mo</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Predictive analytics for global supply chain risks and geopolitical developments. Real-time dashboards and executive reporting.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
                    <button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
                </div>
            </div>
        </div>

        <!-- Product Card 5 -->
        <div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
            <div class="relative h-64 w-full overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAebtJwTzgfAxifEYYMl4jB6XrPHWomKRC7nnZNUOutPzLwPwtinWCp6E4WNUybXBqIH8m4hn3Ro7Uz8GkD640mH1Ik7DhOohBGrRjHgAl25m25GhUZ8Qb7RptgDvA96lI_jvljt66kx3pNiaAmFR8FRqw3PRUkplVhba8g9mXqLb1eQ1ADntM3BZx0xeoVODKrhz6IeMtxLfa8DPmHbgpfrdRouYA9_BXqGNsYQwbxfsrAUEWOr62TOQ" alt="Quantum Link">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-headline-md text-headline-md text-primary">Quantum Link</h3>
                    <span class="font-label-md text-label-md text-secondary">$950/mo</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Next-generation SD-WAN connectivity with quantum-resistant encryption protocols for secure inter-office communication.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
                    <button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
                </div>
            </div>
        </div>

        <!-- Product Card 6 -->
        <div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
            <div class="relative h-64 w-full overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAr9X0B5tlk41ZRRSbTr7NfkJ_G0wLPk3uHY1BPw0cVLPaQoX5Ay3ZjzY-j_emPVMV435eEDfmIVBT81_9vndpJX2kFK6x1Xfza_wvmhiVozQRSVwvUD08xuxRHw5F_p6Q-YLIau_BGfxdlK2pNG-NLKRx2jxd7-O-3RUzkMNoib-tR7_1a6SI4rilgf2SGubdCI4jVgA86giMIYq66RBvt-BiWIwP6LT_4mDh6f_j3RKmullHkeX0iGg" alt="Compliance Shield">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-headline-md text-headline-md text-primary">Compliance Shield</h3>
                    <span class="font-label-md text-label-md text-secondary">$1,800/yr</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Automated compliance mapping for GDPR, HIPAA, and SOC2. Real-time gap analysis and documentation generator.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
                    <button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
                </div>
            </div>
        </div>
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
            button.addEventListener('mousedown', function(e) {
                this.style.opacity = '0.8';
            });
            button.addEventListener('mouseup', function(e) {
                this.style.opacity = '1';
            });
            button.addEventListener('mouseleave', function(e) {
                this.style.opacity = '1';
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
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