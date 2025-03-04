<?php

namespace App\Models;

use App\Casts\DailyTimetable;
use App\Casts\TaskImportSettings;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory;

    protected $table = 'app_tasks';

    protected $guarded = ['id'];

    static public string $table_to_tag = 'app_task_to_tags';

    protected $casts = [
        'daily_timetable' => DailyTimetable::class,
//        'file_information' => TaskImportSettings::class,
        'import_settings' => TaskImportSettings::class,
    ];

    protected $attributes = [
        'items_max_per_hour' => 1000,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->isDirty('file') && ($model->getOriginal('file') !== null)) {
                Storage::disk()->delete($model->getOriginal('file'));
                $model->timetable()->delete();
            }
        });

        static::deleting(function ($model) {
            if ($model->file) {
                Storage::disk()->delete($model->file);
            }
        });

        static::creating(function (self $model) {
            if ($model->file && empty($model->attributes['import_settings'])) {
                $model->import_settings = [];
            }
        });
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(TaskTag::class, static::$table_to_tag, 'task_id', 'tag_id',);
    }

    public function timetable(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskTimetable::class);
    }

}
