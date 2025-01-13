<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RuleAbility;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function abilities()
    {
        return $this->hasMany(RuleAbility::class);
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    protected static function createWithAbilies(Request $request)
    {
        DB::beginTransaction();
        try {


            $rule = Rule::create([
                'name' => $request->post('name')
            ]);

            foreach ($request->post('abilities') as $ability => $val) {
                RuleAbility::create([
                        'rule_id' => $rule->id,
                        'ability' => $ability,
                        'type' => $val
                    ]

                );
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $rule;
    }


    public function updateWithAbilies(Request $request)
    {
        DB::beginTransaction();
        try {

            $rule = $this->update([
                'name' => $request->post('name')
            ]);

            // Get the list of abilities sent in the request
            $abilitiesToUpdate = $request->post('abilities');

            // Delete abilities that are not present in the request
            RuleAbility::where('rule_id', $this->id)
                ->whereNotIn('ability', array_keys($abilitiesToUpdate))
                ->delete();

            foreach ($request->post('abilities') as $ability => $val) {
                RuleAbility::updateOrCreate([
                    'rule_id' => $this->id,
                    'ability' => $ability
                ], [
                    'type' => $val
                ],
                );
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $this;

    }
}
