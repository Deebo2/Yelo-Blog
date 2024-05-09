<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')
                ->schema([
                    TextInput::make('title')
                    ->required()->minLength(1)->maxLength(150)
                    ->live()
                    ->afterStateUpdated(function (string $operation, $state, Set $set){
                        if($operation === 'edit'){
                            return ;
                        }
                        $set('slug',str()->slug($state));
                    }),
                    TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150),
                    RichEditor::make('body')->fileAttachmentsDirectory('posts/images')->columnSpanFull()
                ])->columns(2),
                Section::make('Meta')
                ->schema([
                    Select::make('user_id')
                    ->relationship(name:'author',titleAttribute:'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    Select::make('category')
                    ->multiple()
                    ->relationship('categories','title')->searchable(),
                    FileUpload::make('image')->image()->directory('posts/thumbnails')->columnSpanFull(),
                    DateTimePicker::make('published_at'),
                    Checkbox::make('featured')
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('title')->searchable()->sortable()->wrap(),
                TextColumn::make('slug')->searchable()->sortable()->wrap(),
                TextColumn::make('author.name')->searchable()->sortable(),
                TextColumn::make('published_at')->date('Y-m-d')->searchable()->sortable(),
                CheckboxColumn::make('featured')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
