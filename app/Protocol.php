<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Protocol_ID
 * @property string $Protocol_Name
 * @property string $Protocol_Type
 * @property string $Image
 * @property int $Description
 * @property CenterProtocol $centerProtocol
 * @property Center[] $centers
 */
class Protocol extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Protocol_ID';

    /**
     * @var array
     */
    protected $fillable = ['Protocol_Name', 'Protocol_Type', 'Image', 'Description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centerProtocol()
    {
        return $this->belongsTo('App\CenterProtocol', 'Protocol_ID', 'Protocol_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function centers()
    {
        return $this->belongsToMany('App\Center', null, 'Protocol_ID', 'Center_ID');
    }
}
