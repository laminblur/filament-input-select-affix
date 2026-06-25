<?php

use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Marvinosswald\FilamentInputSelectAffix\Tests\Fixtures\Livewire;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;

function createField(string $name, ?Closure $configure = null): TextInputSelectAffix
{
    $livewire = Livewire::make();

    if (class_exists(ComponentContainer::class)) {
        $field = (new TextInputSelectAffix($name))
            ->container(ComponentContainer::make($livewire));
    } else {
        Form::make($livewire)
            ->schema([
                $field = TextInputSelectAffix::make($name),
            ]);
    }

    if ($configure) {
        $configure($field);
    }

    return $field;
}

it('it works without a select like a normal text field', function () {
    $field = createField(Str::random());

    expect($field)
        ->hasSelect()->toBeFalse();
});

it('accepts select', function () {
    $field = createField(Str::random(), fn (TextInputSelectAffix $field) => $field->select(Select::make('select')));

    expect($field)
        ->hasSelect()->toBeTrue();
});
