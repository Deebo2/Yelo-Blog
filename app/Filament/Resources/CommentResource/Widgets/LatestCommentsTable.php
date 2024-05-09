<?php

namespace App\Filament\Resources\CommentResource\Widgets;

use App\Filament\Resources\CommentResource;
use App\Models\Comment;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestCommentsTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::whereDate('created_at','>',now()->subDays(7)->startOfDay()),
            )
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('post.title')->wrap(),
                TextColumn::make('comment_body')->wrap(),
                TextColumn::make('created_at')->date()->sortable(),
            ])
            ->actions([
                Action::make('View')
                ->url(fn (Comment $record): string => CommentResource::getUrl('edit',['record' => $record]))
                ->openUrlInNewTab()
            ]);
    }
}
