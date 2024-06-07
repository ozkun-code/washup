<ul class="menu p-4 w-80 min-h-full bg-base-100 text-base-content border-r-2 border-base-300 space-y-4">
    <!-- Sidebar content here -->
    <li>
        <h class="menu-title">Dashboard</h>
        <ul>
            <li>
                <a href="{{ route('home') }}" @class(['active' => Route::is('home')]) wire:navigate>
                    <x-tabler-dashboard class="size-5" />
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.actions') }}" @class(['active' => false]) wire:navigate>
                    <x-tabler-file-plus class="size-5" />
                    <span>Input Transaksi</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <h class="menu-title">Data Master</h>
        <ul>
            <li>
                <a href="{{ route('service.index') }}" @class(['active' => Route::is('service.index')]) wire:navigate>
                    <x-tabler-layout-grid-add class="size-5" />
                    <span>Service List</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.index') }}" @class(['active' => Route::is('customer.index')]) wire:navigate>
                    <x-tabler-users class="size-5" />
                    <span>Data Customer</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.index') }}" @class(['active' => Route::is('voucer.index')]) wire:navigate>
                    <x-tabler-basket-discount class="size-5" />
                    <span>Voucer</span>
                </a>
            </li>
            <li>

                <a href="{{ route('transaksi.index') }}" @class(['active' => Route::is('transaksi.index')]) wire:navigate>
                    <x-tabler-file class="size-5" />
                    <span>Riwayat Transaksi</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <h class="menu-title">Account</h>
        <ul>
            <li>
                <a href="{{ route('profile') }}" @class(['active' => Route::is('profile')]) wire:navigate>
                    <x-tabler-user class="size-5" />
                    <span>Edit Profile</span>
                </a>
            </li>
            <li>
                <button wire:click="logout">
                    <x-tabler-logout class="size-5" />
                    <span>logout</span>
                </button>
        </ul>
    </li>

</ul>
