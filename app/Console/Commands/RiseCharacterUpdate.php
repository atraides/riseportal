<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xklusive\BattlenetApi\Services\RiseService;
use App\User;
use App\Character;

use App\CharacterUpdates;

class RiseCharacterUpdate extends Command
{

    use CharacterUpdates;
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
    public function handle(RiseService $wow)
    {
        $users = User::all();
        $cacheOld = config('battlenet-api.cache');
        config(['battlenet-api.cache' => false]);

        $bar = $this->output->createProgressBar(count($users));
        $bar->setFormat('<fg=green>%message:-20s%:</> [%bar%] %current%/%max% %percent:3s%% %elapsed:6s%');
        $bar->setBarWidth(100);
 
        foreach ($users as $user) {
            
            $bar->setMessage($user->name);
            $wow->getProfileCharacters([], $user->bnet->access_token, $user->id);
            $bar->advance();
        }
        $bar->finish(); 

        config(['battlenet-api.cache' => $cacheOld ?: true]);
    }
}
