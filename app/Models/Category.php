<?php

namespace App\Models;

use App\Traits\HasSlug;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'image','is_active'];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public static function getForm($categoryId = null) : array
    {
        return [

            Section::make([
                Grid::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live( debounce: 500)
                            ->afterStateUpdated(
                            // fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                fn(string $operation, $state, Set $set) =>  $set('slug', Str::slug($state)) ),

                        TextInput::make('slug')
                            ->maxLength(255)
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->unique(Category::class, 'slug', ignoreRecord: true),


                ]),
            FileUpload::make('image')
                ->image()
                ->directory('categories'),

            Toggle::make('is_active')
                ->default(true)
                ->required(),

        ]
    )];
}
}

/*
                ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->minLength(3)
                    ->maxLength(200)
                    ->unique(static::getModel(), 'name', ignoreRecord: true)
                    ->label(__('Nombre'))
                ->columnSpanFull(),
                FileUpload::make('image')
                    ->label(__('Imagen'))
                    ->Image()
                    ->maxSize(4096)
                    ->placeholder(__('Imagen de la categoria'))
                    ->columnSpanFull(),
                Checkbox::make('is_active')
                    ->columns(2)
                    ->label(__('está activa')),
                ])
                ]);*/
