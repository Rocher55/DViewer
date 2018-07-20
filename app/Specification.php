<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Protocol_Specification_ID
 * @property string $Title
 * @property string $Type
 * @property string $Body
 * @property string $References
 * @property string $Image
 * @property string $Image_Extension
 * @property int $Protocol_ID
 * @property Protocol $protocol
 */
class Specification extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'protocol_specifications';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Protocol_Specification_ID';

    /**
     * @var array
     */
    protected $fillable = ['Title', 'Type', 'Body', 'References', 'Image', 'Image_Extension', 'Protocol_ID'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function protocol()
    {
        return $this->belongsTo('App\Protocol', 'Protocol_ID', 'Protocol_ID');
    }
}
