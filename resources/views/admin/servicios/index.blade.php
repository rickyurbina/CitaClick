@extends('layouts.admin')

@section('page_title', 'Gestión de Servicios y Colaboradores')

@section('content')
    <div class="max-w-container-max mx-auto">
        <nav class="flex items-center gap-xs text-body-sm text-on-surface-variant mb-lg">
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-secondary font-semibold">Service Management</span>
        </nav>

        <div class="mb-xl border-b border-outline-variant flex gap-xl">
            <button class="pb-md font-label-md text-label-md active-tab transition-all" id="btn-services" onclick="switchTab('services')">Manage Services</button>
            <button class="pb-md font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-all" id="btn-collaborators" onclick="switchTab('collaborators')">Manage Collaborators</button>
        </div>

        <div class="space-y-lg block" id="view-services">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Available Services</h3>
                    <p class="text-body-sm text-on-surface-variant mt-1">Configure and manage your organization's service catalog.</p>
                </div>
                <button class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
                    <span class="material-symbols-outlined">add</span>
                    Add New Service
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
                    <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div>
                        <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Total Services</p>
                        <h4 class="text-headline-md font-bold text-on-surface">24</h4>
                    </div>
                </div>
                <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
                    <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Avg. Price</p>
                        <h4 class="text-headline-md font-bold text-on-surface">$1,240</h4>
                    </div>
                </div>
                <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
                    <div class="w-12 h-12 rounded-full bg-on-primary-fixed-variant flex items-center justify-center text-white">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <div>
                        <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Service Growth</p>
                        <h4 class="text-headline-md font-bold text-on-surface">+12%</h4>
                    </div>
                </div>
            </div>
            <div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Service Name</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Category</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Price</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-lg py-4">
                                    <div class="flex items-center gap-md">
                                        <div class="w-8 h-8 rounded bg-primary-container text-on-primary-container flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">shield</span>
                                        </div>
                                        <span class="font-body-md font-semibold">Enterprise Security Audit</span>
                                    </div>
                                </td>
                                <td class="px-lg py-4"><span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-full text-xs font-medium">Compliance</span></td>
                                <td class="px-lg py-4 font-body-md text-on-surface">$4,500.00</td>
                                <td class="px-lg py-4 text-right">
                                    <div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Edit"><span class="material-symbols-outlined">edit</span></button>
                                        <button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors" title="Delete"><span class="material-symbols-outlined">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-lg hidden" id="view-collaborators">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Manage Team Members</h3>
                    <p class="text-body-sm text-on-surface-variant mt-1">Invite and manage roles for your professional services team.</p>
                </div>
                <button class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
                    <span class="material-symbols-outlined">person_add</span>
                    Add New Collaborator
                </button>
            </div>
            <div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Name</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Role</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Status</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr class="hover:bg-surface-container-low transition-colors group">
                                <td class="px-lg py-4">
                                    <div class="flex items-center gap-md">
                                        <img class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBf7MmwFU-PD5biYa6pTcObLeS6YvDwcx8Z9avc6rpOekdBVibO20luFPMXKrB01gt9BLitY4DQqBrS0824ywejZa_7rS_z2taYnoKsWhJXV4E8w1bLe_o7V-CR-3kOdJD6zvu2wuQMsDMoxjyrfn-keJ1Ma6fnIK2unjsWmQU95Nr8C-6V-Xd5Bl5NqC0ZdUQgLB-gXPJQAs9IeVwTHhymzmnMcqdT6gdfu-JXwJo94NcaxM94tKE3GA" alt="David Chen">
                                        <div>
                                            <div class="font-body-md font-semibold text-on-surface">David Chen</div>
                                            <div class="text-xs text-on-surface-variant">david.c@securecorp.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-lg py-4 text-body-sm text-on-surface">Lead Architect</td>
                                <td class="px-lg py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-container text-on-secondary-container">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary mr-1.5"></span>
                                        Active
                                    </span>
                                </td>
                                <td class="px-lg py-4 text-right">
                                    <div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors"><span class="material-symbols-outlined">edit</span></button>
                                        <button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors"><span class="material-symbols-outlined">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchTab(tab) {
            const servicesView = document.getElementById('view-services');
            const collaboratorsView = document.getElementById('view-collaborators');
            const btnServices = document.getElementById('btn-services');
            const btnCollaborators = document.getElementById('btn-collaborators');

            if (tab === 'services') {
                servicesView.classList.remove('hidden');
                servicesView.classList.add('block');
                collaboratorsView.classList.remove('block');
                collaboratorsView.classList.add('hidden');
                btnServices.classList.add('active-tab');
                btnServices.classList.remove('text-on-surface-variant');
                btnCollaborators.classList.remove('active-tab');
                btnCollaborators.classList.add('text-on-surface-variant');
            } else {
                servicesView.classList.remove('block');
                servicesView.classList.add('hidden');
                collaboratorsView.classList.remove('hidden');
                collaboratorsView.classList.add('block');
                btnCollaborators.classList.add('active-tab');
                btnCollaborators.classList.remove('text-on-surface-variant');
                btnServices.classList.remove('active-tab');
                btnServices.classList.add('text-on-surface-variant');
            }
        }

        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function() {
                const toast = document.getElementById('toast');
                if (toast) {
                    toast.classList.remove('translate-y-20', 'opacity-0');
                    setTimeout(() => {
                        toast.classList.add('translate-y-20', 'opacity-0');
                    }, 3000);
                }
            });
        });
    </script>
@endpush