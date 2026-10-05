<div class="fi-section rounded-2xl p-4 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold" style="color: var(--c-gold, #e5c173)">
            {{ $this->getSapaan() }}, {{ auth()->user()->name }}
        </h2>
        <p class="text-sm" style="color: var(--c-muted, #d1b473)">
            Berikut ringkasan aktivitas laboratorium hari ini.
        </p>
    </div>
    <form action="{{ route('filament.admin.auth.logout') }}" method="POST">
        @csrf
        <button type="submit" class="fi-btn fi-btn-outlined text-sm px-3 py-1.5 rounded-lg border">
            Keluar
        </button>
    </form>
</div>