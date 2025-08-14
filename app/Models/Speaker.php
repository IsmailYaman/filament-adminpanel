<?php

namespace App\Models;

use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Speaker extends Model
{
    use HasFactory;

    const QUALIFICATIONS = [
        'business-leader' => 'Business Leader',
        'charisma' => 'Charisma',
        'first-time' => 'First Time Speaker',
        'hometown-hero' => 'Hometown Hero',
        'laracasts-contributor' => 'Laracasts Contributor',
        'twitter-influencer' => 'Twitter Influencer',
        'youtube-influencer' => 'Youtube Influencer',
        'open-source' => 'Open So urce Creator / Maintainer',
        'unique-perspective' => 'Unique Perspective',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'qualifications' => 'array',
        ];
    }

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class);
    }

    public function talks(): HasMany
    {
        return $this->hasMany(Talk::class);
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            FileUpload::make('avatar')
                ->avatar()
                ->directory('speakers')
                ->imageEditor()
                ->maxSize(1024 * 1024 * 10),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            RichEditor::make('bio')
                ->maxLength(255),
            TextInput::make('twitter_handle')
                ->maxLength(255),
            CheckboxList::make('qualifications')
                ->columnSpanFull()
                ->searchable()
                ->bulkToggleable()
                ->options(self::QUALIFICATIONS)
                ->descriptions([
                    'business-leader' => 'This dude is a real leader',
                    'charisma' => 'This n-word has charm',
                    'first-time' => 'This is a first time speaker',
                    'hometown-hero' => 'This is a hometown hero',
                    'laracasts-contributor' => 'This is a Laracasts contributor',
                    'twitter-influencer' => 'This is a Twitter influencer',
                    'youtube-influencer' => 'This is a Youtube influencer',
                    'open-source' => 'This is an open source creator / maintainer',
                    'unique-perspective' => 'This has a unique perspective',
                ])
                ->columns(3),
        ];
    }
}
