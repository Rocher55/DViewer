<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $SampleType_ID
 * @property string $SampleType_Name
 * @property EaAnalyse[] $eaAnalyses
 */
class Sample extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sampletypes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SampleType_ID';

    /**
     * @var array
     */
    protected $fillable = ['SampleType_Name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eaAnalyses()
    {
        return $this->hasMany('App\EaAnalyse', 'SampleType_ID', 'SampleType_ID');
    }
}
