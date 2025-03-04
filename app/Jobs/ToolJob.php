<?php

namespace App\Jobs;

use App\Actions\Tool\ToolActions;
use App\Models\Tool;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ToolJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $tool_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ToolActions::step($this->tool_id);
    }
}
