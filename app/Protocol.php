<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Protocol_ID
 * @property string $Protocol_Name
 * @property string $Protocol_Type
 * @property CenterProtocol $centerProtocol
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
    protected $fillable = ['Protocol_Name', 'Protocol_Type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centerProtocol()
    {
        return $this->belongsTo('App\CenterProtocol', 'Protocol_ID', 'Protocol_ID');
    }
}
