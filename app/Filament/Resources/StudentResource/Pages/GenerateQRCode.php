<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class GenerateQRCode extends Page
{
    use InteractsWithRecord;

    protected
    static string $resource = StudentResource::class;

    protected static string $view = 'filament.resources.student-resource.pages.generate-q-r-code';

    public function mount(int | string $record) : void
    {
        $this->record = $this->resolveRecord($record);
        static::authorizeResourceAccess();
    }
}
