<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\UserStatusEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class UserResource extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    protected static ?string $model = User::class;

    /**
     * The navigation icon for the resource.
     */
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('image_url')->circular()->label('Image'),
                Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('username')->label('Username')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Roles')->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('Created at'),
                Tables\Columns\TextColumn::make('updated_at')->label('Updated at'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(
                        array_column(UserStatusEnum::cases(), 'value'))
                    ->attribute('status'),
                Tables\Filters\SelectFilter::make('role')
                    ->relationship('roles', 'name')
                    ->attribute('roles'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function ($query, $data) {

                        /** @var Builder<User> $query */
                        $query = $query;

                        /** @var array{created_from: string, created_until: string} $data */
                        $data = $data;

                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],

                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
