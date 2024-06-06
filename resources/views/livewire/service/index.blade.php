<div class="page-wrapper">
    <div class="flex justify-between">
        <input type="search" class="input input-bordered" placeholder="pencarian" wire:model.live="search" >
        <button class="btn btn-primary" wire:click="$dispatch('createService')">
            <x-tabler-plus class="size-5" />
            <span>Tambah Service</span>
        </button>
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th >Estimated Time</th>
                    <th >Unit</th>
                    <th>Description</th>
                    <th class="text-center">Action</th>
                </tr>
            <tbody>
                @foreach ($services as $service)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        <div class="flex gap-3 items-center">
                            <div class="avatar">
                                <div class="w-12 rounded-lg">
                                    <img src="{{ $service->foto}}" alt="">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div>{{ $service->name}}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>{{ $service->harga}}</td>
                    
                    <td>{{ $service->estimated_completion_time}}</td>
                    <td>{{ $service->unit}}</td>
                    <td class="whitespace-normal w-80">
                        <div class="line-clamp-2">
                            {{ $service->description}}
                        </div>
                    </td>
                    <td>
                        <div class="flex justify-center gap-1">
                            <button class="btn btn-xs btn-square" wire:click="$dispatch('editService', {service : {{ $service->id }}})">
                                <x-tabler-edit class="size-4" />
                            </button>
                            <button class="btn btn-xs btn-square" wire:click="$dispatch('deletService', {service : {{ $service->id }}})">
                                <x-tabler-trash class="size-4" />
                            </button>
                        </div>
                    </td>
                </tr>               
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('service.actions')
</div>
