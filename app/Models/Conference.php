<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use App\Enums\Region;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Database\Factories\ConferenceFactory;
use App\Enums\TalkStatus;

class Conference extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'region' => Region::class,
            'venue_id' => 'integer',
        ];
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class);
    }

    public function talks(): BelongsToMany
    {
        return $this->belongsToMany(Talk::class);
    }

    public static function getForm(): array
    {
        return [
            Actions::make([
                Action::make('Fill data')
                    ->visible(function (string $operation) {
                        if ($operation != 'create') {
                            return false;
                        }
                        if(! app()->environment('local')) {
                            return false;
                        }
                        return true;
                    })
                    ->label('Fill data')
                    ->icon('heroicon-o-sparkles')
                    ->action(function ($livewire) {
                        $data = Conference::factory()->make()->toArray();
                        $livewire->form->fill($data);
                    }),
            ]),
            Section::make('Conference Details')
                ->description('This is the conference details')
                ->collapsible()
                ->icon('heroicon-o-megaphone')
                ->columns(2)
                ->schema([
                    
                    TextInput::make('name')
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                    MarkdownEditor::make('description')
                        ->columnSpanFull()
                        ->required(),
                    DateTimePicker::make('start_date')
                        ->required()
                        ->native(false),
                    DateTimePicker::make('end_date')
                        ->required()
                        ->native(false),
                    Fieldset::make('Status')
                        ->schema([
                            Select::make('status')
                                ->columnSpanFull()
                                ->enum(TalkStatus::class)
                                ->options(TalkStatus::class)
                                ->default(TalkStatus::SUBMITTED),
                            Toggle::make('is_published')
                                ->default(false)
                                ->columnSpanFull(),
                        ])
                ]),
            Section::make('Location')
                ->columns(2)
                ->schema([

                    Select::make('region')
                        ->live()
                        ->enum(Region::class)
                        ->options(Region::class),
                    Select::make('venue_id')
                        ->searchable()
                        ->preload()
                        ->createOptionForm(Venue::getForm())
                        ->editOptionForm(Venue::getForm())
                        ->relationship('venue', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                            return $query->where('region', $get('region'));
                        }),
                ]),
            Section::make('Speakers')
                ->columnSpanFull()
                ->schema([
                    CheckboxList::make('speakers')
                        ->columns(3)
                        ->searchable()
                        ->bulkToggleable()
                        ->relationship('speakers', 'name')
                        ->options(Speaker::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ]),
        ];
    }
}
