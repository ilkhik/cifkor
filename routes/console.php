<?php

use Illuminate\Foundation\Inspiring;

/*
  |--------------------------------------------------------------------------
  | Console Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of your Closure based console
  | commands. Each Closure is bound to a command instance allowing a
  | simple approach to interacting with each command's IO methods.
  |
 */

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('updatedb', function () {
    DB::statement('ALTER TABLE `groups` ADD `amount` INT');

    $groups = App\Group::all();

    function fillChildren($groups, $id)
    {
        $amount = 0;
        foreach ($groups as $group) {
            if ($group->id_parent === $id) {
                $am = fillChildren($groups, $group->id);
                $group->amount = $am;
                $amount += $am;
            }
        }
        $amount += App\Product::where('id_group', $id)->count();
        
        return $amount;
    }
    
    fillChildren($groups, 0);
    
    foreach ($groups as $group) {
        $group->save();
    }

});
