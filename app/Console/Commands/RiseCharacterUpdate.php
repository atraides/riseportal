<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xklusive\BattlenetApi\Services\WowService;
use App\User;
use App\Character;

class RiseCharacterUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rise:character:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the character list for the registered users';

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
    public function handle(WoWService $wow)
    {
        $users = User::all();
        $cacheOld = config('battlenet-api.cache');
        config(['battlenet-api.cache' => false]);

        $bar = $this->output->createProgressBar(count($users));
        $bar->setFormat('<fg=green>%message:20s%:</> %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%');
        $bar->setBarWidth(100);
 
        foreach ($users as $user) {
            $characters = $wow->getProfileCharacters([], $user->bnet->access_token, $user->id)->first();
            $bar->setMessage($user->name);

            foreach ( $characters as $character ) {
                $m = $user->characters()->firstOrNew(array('name' => $character->name));
                $m->realm = $character->realm;
                $m->battlegroup = $character->battlegroup;
                $m->class = $character->class;
                $m->race = $character->race;
                $m->gender = $character->gender;
                $m->level = $character->level;
                $m->achievementPoints = $character->achievementPoints;
                $m->thumbnail = $character->thumbnail;
                $m->lastModified = ((int)$character->lastModified / 1000);
                $m->save();
            }
            $bar->advance();
        }
        $bar->finish(); 

        config(['battlenet-api.cache' => $cacheOld ?: true]);
    }
}
