<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Analyse_ID
 * @property string $Gene_Symbol
 * @property string $Probe_ID
 * @property float $value1
 * @property float $value2
 */
class Experiment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['Analyse_ID', 'Gene_Symbol', 'Probe_ID', 'value1', 'value2'];

}
