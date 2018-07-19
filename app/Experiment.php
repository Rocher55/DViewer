<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Experiments_ID
 * @property int $Analyse_ID
 * @property float $value1
 * @property float $value2
 * @property int $Gene_ID
 * @property string $Gene_Symbol
 * @property string $Probe_ID
 */
class Experiment extends Model{

    public $timestamps = false;
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Experiments_ID';

    /**
     * @var array
     */
    protected $fillable = ['Analyse_ID', 'value1', 'value2', 'Gene_ID', 'Gene_Symbol', 'Probe_ID'];

}
