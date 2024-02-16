<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updatePassword')
                ->form([
                    TextInput::make('password')->password()->confirmed()->required(),
                    TextInput::make('password_confirmation')->password()->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['password'=>$data['password']]);
                    Notification::make()->success()->title('Password updated successfully')->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
