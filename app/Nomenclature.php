<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Nomenclature_ID
 * @property string $NameN
 * @property string $CDISC
 * @property Biochemistry[] $biochemistries
 * @property FoodDiary[] $foodDiaries
 */
class Nomenclature extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Nomenclature_ID';

    /**
     * @var array
     */
    protected $fillable = ['NameN', 'CDISC'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biochemistries()
    {
        return $this->hasMany('App\Biochemistry', 'Nomenclature_ID', 'Nomenclature_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foodDiaries()
    {
        return $this->hasMany('App\FoodDiary', 'Nomenclature_ID', 'Nomenclature_ID');
    }
}
