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

        // $bar = $this->output->createProgressBar(count($user->all()));

        foreach ($users as $user) {
            foreach ($wow->getProfileCharacters([], $user->bnet->first()->access_token)->characters as $character) {
                print_r($character);
                // $this->info($character->name.'@'.$user->name);
            }
            
/*            $m = Character::firstOrNew(array('name' => $member->character->name));
            $m->realm
            $m->battlegroup
            $m->class = $member->character->class;
            $m->race = $member->character->race;
            $m->gender = $member->character->
            $m->level = $member->character->
            $m->achievementPoints = $member->character->
            $m->thumbnail
            $m->lastModified = $member->character->
            $m->save();*/

            // $bar->advance();
        }

        // $bar->finish();

    }
}
