<x-filament-panels::page>
    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($this->getRecord()->email) !!}
</x-filament-panels::page>
