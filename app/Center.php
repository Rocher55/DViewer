<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Center_ID
 * @property int $Site_ID
 * @property string $Center_Acronym
 * @property string $Center_City
 * @property string $Center_Country
 * @property string $Country_Acronym
 * @property CenterProtocol $centerProtocol
 */
class Center extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Center_ID';

    /**
     * @var array
     */
    protected $fillable = ['Site_ID', 'Center_Acronym', 'Center_City', 'Center_Country', 'Country_Acronym'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centerProtocol()
    {
        return $this->belongsTo('App\CenterProtocol', 'Center_ID', 'Center_ID');
    }
}
