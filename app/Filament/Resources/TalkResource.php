<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TalkResource\Pages;
use App\Models\Talk;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Enums\TalkLength;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class TalkResource extends Resource
{
    protected static ?string $model = Talk::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Talk::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->description(function (Talk $record) {
                        return Str::limit($record->description, 50);
                    }),
                ImageColumn::make('speaker.avatar')
                    ->label('Speaker Avatar')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?background-0D8ABC&color=fff&name=' . urlencode($record->speaker->name);
                    }),
                TextColumn::make('speaker.name')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('new_talk'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
                IconColumn::make('length')
                    ->icon(function ($state) {
                        return match ($state) {
                            TalkLength::LIGHTNING => 'heroicon-o-bolt',
                            TalkLength::NORMAL => 'heroicon-o-megaphone',
                            TalkLength::KEYNOTE => 'heroicon-o-key',
                        };
                    })
            ])
            ->filters([
                TernaryFilter::make('new_talk'),
                SelectFilter::make('speaker')
                    ->relationship('speaker', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Filter::make('has_avatar')
                    ->label('Show speakers with avatars')
                    ->toggle()
                    ->query(function ($query) {
                        return $query->whereHas('speaker', function ($query) {
                            $query->whereNotNull('avatar');
                        });
                    })
            ])
            ->actions([
                EditAction::make()
                    ->slideOver(),
                Action::make('approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (Talk $record) {
                        $record->approve();
                    })->after(function () {
                        Notification::make()->success()
                            ->duration(1000)
                            ->title('Talk Approved')
                            ->body('The talk has been approved')
                            ->send();
                    }),
                Action::make('reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->action(function (Talk $record) {
                        $record->reject();
                    })->after(function () {
                        Notification::make()->success()
                            ->duration(1000)
                            ->title('Talk Rejected')
                            ->body('The talk has been rejected')
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTalks::route('/'),
            'create' => Pages\CreateTalk::route('/create'),
            // 'edit' => Pages\EditTalk::route('/{record}/edit'),
        ];
    }
}
