<div>
    <div class="mt-2" wire:poll.750ms>
        <span class="badge bg-info">generate:sitemap {{ optional(\App\Models\Scheduler::where('task', 'generate:sitemap')->first())->updated_at }}</span>
        <span class="badge bg-info ">update:db {{ optional(\App\Models\Scheduler::where('task', 'update:db --lastest')->first())->updated_at }}</span>
    </div>
</div>
