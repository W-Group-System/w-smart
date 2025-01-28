<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierEvaluationResult extends Model
{
    use SoftDeletes;
    protected $table = "supplier_evaluation_result";
    protected $fillable = [
        'evaluation_id', 'result', 'rating1', 'rating2', 'rating3', 'rating4', 'rating5', 'rating6', 'rating7', 'score1', 'score2', 'score3', 'score4', 'score5', 'score6', 'score7', 'remarks1', 'remarks2', 'remarks3', 'remarks4'
    ];
}
