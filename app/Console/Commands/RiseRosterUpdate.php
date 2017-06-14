<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xklusive\BattlenetApi\Services\RiseService;
use App\User;
use App\Character;

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
    public function handle(RiseService $wow)
    {
        $dummyUser = User::where('name','RiseGuild')->first();

        $cacheOld = config('battlenet-api.cache');
        config(['battlenet-api.cache' => false]);
        $guild = $wow->getGuildMembers('Arathor', 'Rise Legacy');
        config(['battlenet-api.cache' => $cacheOld ?: true]);

         // We only select characters belonging to the Dummy account because these are the orphans.
        $characters = Character::with('user')->get();

        $bar = $this->output->createProgressBar(count($guild->get('members')));
        $bar->setFormat('<fg=green>%message:-30s%:</> [%bar%] %current%/%max% %percent:3s%% %elapsed:6s%');
        $bar->setBarWidth(100);

        foreach ($guild->get('members') as $member) {
            $member->character->lastModified = (int) $member->character->lastModified / 1000;
            $bar->setMessage($member->character->name.'@'.$member->character->realm);
            $character = $characters->where('name', $member->character->name)->where('realm', $member->character->realm);

            if ($character->isEmpty()) {
                // Add a new character to the roster
                $member->character->rank = $member->rank;
                $q = $dummyUser->characters()->create((array) $member->character);
            } else if ($character->first()->user->id == 1) {
                // Character belongs to the Dummy account, lets update it.
                $character->first()->update((array) $character);
            } else {
                // Character belongs to someone else. Do not do anything.
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info(PHP_EOL .'Deleting Members who are not in the guild anymore.');
        // Member::whereNotIn('name', $activeMembers)->delete();
    }
}
