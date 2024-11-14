<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // Fetch the users with 'admin' role
        $users = User::role('admin')->get()->pluck('name', 'id');

        return $form
            ->schema([
                // Base Price field
                TextInput::make('base_price')
                    ->label('Base Price')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Enter the base price of the product.')
                    ->required(),

                // Product Type selection
                Select::make('product_type')
                    ->label('Product Type')
                    ->options([
                        'server' => 'Server',
                        'other' => 'Other',
                    ])
                    ->default('server')
                    ->helperText('Choose the type of product.')
                    ->required(),

                // Provisioned At datetime picker
                DateTimePicker::make('provisioned_at')
                    ->label('Provisioned At')
                    ->helperText('Set the date when the product was provisioned.')
                    ->nullable(),

                // Destroyed At datetime picker
                DateTimePicker::make('destoryed_at')
                    ->label('Destroyed At')
                    ->helperText('Set the date when the product was destroyed.')
                    ->nullable(),

                // Transaction ID input
                TextInput::make('trxID')
                    ->label('Transaction ID')
                    ->helperText('Enter the transaction ID for the product.')
                    ->required(),

                // Duration input (in days)
                TextInput::make('durations')
                    ->label('Duration')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Enter the duration for the product (in days).')
                    ->required(),

                // Total Price input
                TextInput::make('total_price')
                    ->label('Total Price')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Enter the total price of the product.')
                    ->required(),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('User')
                    ->getStateUsing(fn($record) => $record->user ? $record->user->name : 'Unknown') // Fetch name from the related User model
                    // ->url(fn ($record) => route('admin.users.show', $record->user_id)) // Link to the user details page
                    ->toggleable(),
                TextColumn::make('server_id')
                    ->label('Server')
                    ->getStateUsing(fn($record) => $record->server ? $record->server->server_name : 'Unknown') // Fetch slug from the related Server model
                    // ->url(fn ($record) => route('admin.servers.show', $record->server_id)),
                    ->toggleable(),
                TextColumn::make('base_price'),
                TextColumn::make('product_type'),
                TextColumn::make('trxID')
                    ->copyable()
                    ->badge()
                    ->icon('heroicon-m-square-2-stack'),
                TextColumn::make('total_price'),
                TextColumn::make('verification_status')
                    ->label('Verification Status')
                    ->getStateUsing(fn($record) => $record->isVerified() ? 'Verified' : 'Not Verified')
                    ->badge()
                    ->color(fn($record) => $record->isVerified() ? 'success' : 'danger'),
                TextColumn::make('verified_by'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                // Tables\Actions\DeleteAction::make(),
                Action::make('verify')
                    ->action(function (Product $record) {
                        $record->verify();
                    })

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
