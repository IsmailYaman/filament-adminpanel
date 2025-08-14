<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\TalkLength;
use App\Enums\TalkStatus;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class Talk extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'speaker_id' => 'integer',
            'length' => TalkLength::class,
            'status' => TalkStatus::class,
        ];
    }
    public static function getForm(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            TextInput::make('abstract')
                ->required(),
            Select::make('speaker_id')
                ->relationship('speaker', 'name')
                ->required(),
        ];
    }

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class);
    }
}
