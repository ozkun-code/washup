<div class="page-wrapper">
    <div class="flex justify-between">
        <input type="search" class="input input-bordered" placeholder="pencarian" wire:model.live="search" >
        <button class="btn btn-primary" wire:click="$dispatch('createCustomer')">
            <x-tabler-plus class="size-5" />
            <span>Tambah customer</span>
        </button>
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->contact }}</td>
                    <td>{{ $customer->user->email }}</td>
                    
                    <td>
                        <div class="flex justify-center gap-1">
                            <button class="btn btn-xs btn-square" wire:click="$dispatch('editCustomer', {customer : {{ $customer->id }}})">
                                <x-tabler-edit class="size-4" />
                            </button>
                            <button class="btn btn-xs btn-square" wire:click="$dispatch('deletCustomer', {customer : {{ $customer->id }}})">
                                <x-tabler-trash class="size-4" />
                            </button>
                        </div>
                    </td>
                </tr>               
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('customer.actions')
</div>
