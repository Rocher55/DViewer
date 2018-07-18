<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Gene_ID
 * @property string $Gene_Symbol
 * @property string $Probe_ID
 * @property string $Gene_Name
 * @property string $Target_ID
 */
class Gene extends Model
{
    public $timestamps = false;
    
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Gene_ID';

    /**
     * @var array
     */
    protected $fillable = ['Gene_Symbol', 'Probe_ID', 'Gene_Name', 'Target_ID'];

}
