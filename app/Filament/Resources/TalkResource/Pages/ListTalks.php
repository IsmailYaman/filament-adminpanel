<?php

namespace App\Filament\Resources\TalkResource\Pages;

use App\Filament\Resources\TalkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Enums\TalkStatus;

class ListTalks extends ListRecords
{
    protected static string $resource = TalkResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Talks'),
            'approved' => Tab::make('Approved')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', TalkStatus::APPROVED);
                }),
            'submitted' => Tab::make('Submitted')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', TalkStatus::SUBMITTED);
                }),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', TalkStatus::REJECTED);
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
