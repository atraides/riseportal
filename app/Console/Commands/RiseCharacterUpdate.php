<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Character;
use App\CharacterUpdates;

use Xklusive\BattlenetApi\Services\WowService;

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
    public function handle(WoWService $wow)
    {
        $users = User::all();
        $cacheOld = config('battlenet-api.cache');
        config(['battlenet-api.cache' => false]);

        $bar = $this->output->createProgressBar(count($users));
        $bar->setFormat('<fg=green>%message:-20s%:</> [%bar%] %current%/%max% %percent:3s%% %elapsed:6s%');
        $bar->setBarWidth(100);
 
        foreach ($users as $user) {
            
            $bar->setMessage($user->name);
            $provider = $user->providers()->where('provider','battlenet')->first();
            if (!empty($provider) && $provider->access_token) {
                $response = $this->updateCharacters($user, $wow->getProfileCharacters([
                    'access_token' => $provider->access_token,
                    'access_scope' => $provider->scope,
                    'user_id'      => $user->id
                ]));

                if (is_a($response, 'GuzzleHttp\Exception\ClientException')) { return ($response); }
            }

            $bar->advance();
        }
        $bar->finish(); 

        config(['battlenet-api.cache' => $cacheOld ?: true]);
    }
}
