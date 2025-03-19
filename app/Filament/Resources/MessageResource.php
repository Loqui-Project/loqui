<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),
                Select::make('sender_id')
                    ->relationship('sender', 'name')
                    ->label('Sender'),
                Forms\Components\Textarea::make('message')->label('MessageCard'),
                Forms\Components\Checkbox::make('is_anon')->label('Is Anonymous'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user.name')->label('Received user name')->searchable(),
                Tables\Columns\TextColumn::make('sender.name')->label('Sender user name')->searchable(),
                Tables\Columns\TextColumn::make('is_anon')->label('Is Anonymous')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_anon')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Created at'),
                Tables\Columns\TextColumn::make('updated_at')->label('Updated at'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
