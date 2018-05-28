<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Technique_ID
 * @property string $Technical_Name
 * @property EaAnalyse[] $eaAnalyses
 */
class Technique extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Technique_ID';

    /**
     * @var array
     */
    protected $fillable = ['Technical_Name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eaAnalyses()
    {
        return $this->hasMany('App\EaAnalyse', 'Technique_ID', 'Technique_ID');
    }
}
