<?php

use Illuminate\Database\Seeder;
use App\Poll;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AuthTableSeeder::class);

        $poll1 = Poll::create([
            'name' => 'Milyen RLP legyen?',
            'infourl' => 'https://goo.gl/FgtZBm',
            'body' => 'Az RLP rendszer jeleneleg átdologzás alatt áll. Ahhoz hogy ez sikeres legyen a ti segítségetek is kell. Szavazzatok az általatok legjobbnak tartott opcióra legkésőbb<br/> <b>2017-06-24 19:00</b>-ig.'
        ]);

        $poll2 = Poll::create([
            'name' => 'Legyen Decay?',
            'body' => 'Szavazzatok az általatok legjobbnak tartott opcióra legkésőbb<br/> <b>2017-06-24 19:00</b>-ig.'
        ]);

        $poll1->options()->create([
            'slug' => 'rlp1',
            'text' => 'RLP v1.0',
            'color' => 'bg-info'
        ]);

        $poll1->options()->create([
            'slug' => 'rlp2',
            'text' => 'RLP v2.0',
            'color' => 'bg-warning'
        ]);

        $poll1->options()->create([
            'slug' => 'licit',
            'text' => 'Anonim Licit',
            'color' => 'bg-danger'
        ]);

        $poll2->options()->create([
            'slug' => 'yes',
            'text' => 'Igen',
            'color' => 'bg-success'
        ]);

        $poll2->options()->create([
            'slug' => 'no',
            'text' => 'Nem',
            'color' => 'bg-danger'
        ]);
    }
}
