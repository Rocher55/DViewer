<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Cid_ID
 * @property int $Patient_ID
 * @property float $Baecke Work
 * @property float $Baecke Sport
 * @property float $Baecke Leisure
 * @property float $Baecke index total
 */
class Physical_activities extends Model{

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['Baecke Work', 'Baecke Sport', 'Baecke Leisure', 'Baecke index total'];

}
