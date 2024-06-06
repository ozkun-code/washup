<div class="card">
    @if ($errors->any())
        <div class="toast toast-top toast-center" id="toast">
            <div class="alert alert-error">
                <x-tabler-alert-square-rounded class="size-5" />
                <span>{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <form class="card-body" wire:submit="login">
        <h3 class="card-title">Selamat Datang</h3>
        <div class="py-4 space-y-2">
            <label @class([
                'input input-bordered flex items-center gap-2',
                'input-error' => $errors->first('email'),
            ])>
                <x-tabler-mail class="size-5" />
                <input type="email" class="grow" placeholder="email" wire:model="email" required />
            </label>
            <label @class([
                'input input-bordered flex items-center gap-2',
                'input-error' => $errors->first('password'),
            ])>
                <x-tabler-key class="size-5" />
                <input type="password" class="grow" placeholder="password" wire:model="password" />
            </label>
        </div>

        <div class="form-control mt-6">
            <button class="btn btn-primary">
                <x-tabler-login class="size-5" />
                <span>login</span>
            </button>
        </div>
    </form>
</div>
