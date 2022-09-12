<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';
    protected $primaryKey = 'id';
    protected $keyType ='integer';

    protected $fillable = [
      'title', 'description', 'source', 'due_date', 'subject_id', 'teacher_id', 'class_id'
    ];

    /**
     * Format the title string to keep consistency by capitalizing
     * the first character of each word in a string
     *
     *
     * @param String $value
     * @return string
     */
    public function setTitleAttribute($value)
    {
      $value = strtolower($value);
      $this->attributes['title'] = ucwords($value);
    }

    /**
     * Format the due date appropriately
     *
     * @param Date $value
     * @return Date
     */
    public function setDueDateAttribute($value)
    {
      $this->attributes['due_date'] = $value;
    }

    /**
     * Apply formatting to the description attribute to keep
     * consistency when saved to the database
     *
     * @param String $value
     * @return string
     */
    public function setDescriptionAttribute($value)
    {
      $this->attributes['description'] = ucfirst($value);
    }



    /**
     * Set the relationship between the Assignment
     * model and the Subject model
     *
     * @return Response
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    /**
     * Result that has many to this class
     *
     * @return Response
     */

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }
}
