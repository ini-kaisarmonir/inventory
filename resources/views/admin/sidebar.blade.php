<!-- Mobile Toggle Button -->
<button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-gray-200 rounded">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 w-64 bg-white border-r transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
    <nav class="p-4 space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
            class="block px-4 py-2 rounded hover:bg-gray-100 font-medium">
            Dashboard
        </a>

        <a href="{{ route('products.index') }}"
            class="block px-4 py-2 rounded hover:bg-gray-100">
            Products
        </a>

        <a href="{{ route('sales.index') }}"
            class="block px-4 py-2 rounded hover:bg-gray-100">
            Sales
        </a>


        <a href="{{ route('report') }}"
            class="block px-4 py-2 rounded hover:bg-gray-100">
            Reports
        </a>
    </nav>
</aside>

<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 md:hidden hidden z-30"></div>

<script>
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>