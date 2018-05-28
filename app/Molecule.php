<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Molecule_ID
 * @property string $Molecule_Name
 * @property EaAnalyse[] $eaAnalyses
 */
class Molecule extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Molecule_ID';

    /**
     * @var array
     */
    protected $fillable = ['Molecule_Name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eaAnalyses()
    {
        return $this->hasMany('App\EaAnalyse', 'Molecule_ID', 'Molecule_ID');
    }
}
