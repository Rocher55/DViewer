<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $Gene_Symbol
 * @property string $Probe_ID
 * @property string $Gene_Name
 * @property string $Target_ID
 */
class Gene extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['Gene_Symbol', 'Probe_ID', 'Gene_Name', 'Target_ID'];

}
