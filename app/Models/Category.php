<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Set;

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
