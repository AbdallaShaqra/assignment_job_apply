<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property string $created_at
 * @property string $updated_at
 * @property JobApplication[] $jobApplications
 */
class JobPost extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['title', 'desc', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobApplications()
    {
        return $this->hasMany('App\Models\JobApplication', 'job_id');
    }
}
