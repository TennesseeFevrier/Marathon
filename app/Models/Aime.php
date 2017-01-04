<?php
/**
 * Created by PhpStorm.
 * User: tennessee.fevrier
 * Date: 15/12/16
 * Time: 13:09
 */

namespace App\Models;

use Nova\Database\ORM\Model as BaseModel;

class Aime extends BaseModel
{
    protected $table = "aime";

    public $timestamps = false;
    protected $fillable = array('id', 'idUtilisateur', 'idHistoire');

    public function histoire() {
        return $this->belongsTo("App\Models\Histoire", "idHistoire");
    }

    public function auteur() {
        return $this->belongsTo("App\Models\User", "idUtilisateur");
    }

}