<?php

namespace App\Listeners;

use App\Events\TableACreated;
use App\Models\TableB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTableB
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TableACreated  $event
     * @return void
     */
    public function handle(TableACreated $event)
    {
        $tableA = $event->tableA;
        $starCount = $tableA->user_star;

        $tableB = new TableB();
        $tableB->star_count = $starCount;
        $tableB->table_a_id = $tableA->id;
        $tableB->updated_at = now();
        $tableB->save();
    }
}
