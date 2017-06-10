<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xklusive\BattlenetApi\Services\WowService;
use App\Member;

class RiseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roster:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the guild roster from Battle.net';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(WowService $wow)
    {
        $guild = $wow->getGuildMembers('Arathor', 'Rise Legacy');

        $bar = $this->output->createProgressBar(count($guild->all()['members']));

        foreach ($guild->all()['members'] as $member) {
            
            $m = Member::firstOrNew(array('name' => $member->character->name));
            $m->rank = $member->rank;
            $m->realm = $member->character->realm;
            $m->save();

            $bar->advance();
        }

        $bar->finish();
    }
}
