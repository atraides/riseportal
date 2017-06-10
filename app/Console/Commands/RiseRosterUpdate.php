<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xklusive\BattlenetApi\Services\WowService;
use App\Member;

class RiseRosterUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rise:roster:update';

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
        $cacheOld = config('battlenet-api.cache');
        config(['battlenet-api.cache' => false]);
        $guild = $wow->getGuildMembers('Arathor', 'Rise Legacy');
        config(['battlenet-api.cache' => $cacheOld ?: true]);

        $activeMembers = array();

        $bar = $this->output->createProgressBar(count($guild->all()['members']));
        $bar->setFormat('<fg=green>%message:-20s%:</> %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%');
        $bar->setBarWidth(100);

        foreach ($guild->all()['members'] as $member) {

            $bar->setMessage($member->character->name);

            array_push( $activeMembers, $member->character->name );

            $m = Member::firstOrNew(array('name' => $member->character->name));
            $m->rank = $member->rank;
            $m->realm = $member->character->realm;
            $m->save();

            $bar->advance();
        }

        $bar->finish();

        $this->info(PHP_EOL .'Deleting Members who are not in the guild anymore.');
        Member::whereNotIn('name', $activeMembers)->delete();
    }
}
