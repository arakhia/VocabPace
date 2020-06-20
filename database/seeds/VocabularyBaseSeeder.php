<?php

use Illuminate\Database\Seeder;

class VocabularyBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\VocabularyBase::class, 100)->create()->each(function($vocabulary){
            $vocabulary->save();
        });
    }
}
