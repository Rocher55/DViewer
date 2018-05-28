<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Analyse_ID
 * @property int $CID_ID
 * @property int $Patient_ID
 * @property int $Molecule_ID
 * @property int $SampleType_ID
 * @property int $Technique_ID
 * @property Molecule $molecule
 * @property Sampletype $sampletype
 * @property Technique $technique
 */
class Analyse extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ea_analyse';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Analyse_ID';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['CID_ID', 'Patient_ID', 'Molecule_ID', 'SampleType_ID', 'Technique_ID'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function molecule()
    {
        return $this->belongsTo('App\Molecule', 'Molecule_ID', 'Molecule_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sampletype()
    {
        return $this->belongsTo('App\Sampletype', 'SampleType_ID', 'SampleType_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technique()
    {
        return $this->belongsTo('App\Technique', 'Technique_ID', 'Technique_ID');
    }
}
