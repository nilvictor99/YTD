<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Services\Utils\Generators\PasswordGenerator;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationGroup(): ?string
    {
        return __('navigation-panel.Administration');
    }

    public static function getNavigationLabel(): string
    {
        return __('users.navegation_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('users.navegation_label');
    }

    public static function getModelLabel(): string
    {
        return __('users.navegation_label_singel');
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('users.user_information'))
                    ->description(__('users.user_information_description'))
                    ->schema([
                        FileUpload::make('avatar_url')
                            ->translateLabel()
                            ->avatar()
                            ->directory('public/avatars')
                            ->image()
                            ->imageEditor()
                            ->downloadable(),
                        Forms\Components\TextInput::make('name')
                            ->translateLabel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->translateLabel()
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                        Forms\Components\TextInput::make('password')
                            ->translateLabel()
                            ->password()
                            ->visibleOn('create')
                            ->revealable()
                            ->required()
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generate')
                                    ->icon('heroicon-m-arrow-path')
                                    ->action(function ($set) {
                                        $set('password', app(PasswordGenerator::class)->generate());
                                    })
                            )
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->translateLabel()
                    ->square()
                    ->visibility('private'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->translateLabel(),

                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()

                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
