<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')->required(),
                Select::make('schedule_id')
                    ->relationship('schedule', 'shift_name')->required(),
                DateTimePicker::make('check_in_time'),
                DateTimePicker::make('check_out_time'),
                Select::make('check_in_location_id')
                    ->relationship('checkInLocation', 'name'),
                Select::make('check_out_location_id')
                    ->relationship('checkOutLocation', 'name'),
                Select::make('status')
                    ->options([
                        'present' => 'Present',
                        'sick' => 'Sick',
                        'permission' => 'Permission',
                        'annual_leave' => 'Annual Leave',
                    ]),
                Textarea::make('remarks'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('schedule.shift_name'),
                TextColumn::make('check_in_time'),
                TextColumn::make('check_out_time'),
                TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Check In')
                    ->label('Check In')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (Attendance $record) {
                        $record->check_in_time = now();
                        $record->save();
                    }),
                Tables\Actions\Action::make('Check Out')
                    ->label('Check Out')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (Attendance $record) {
                        $record->check_out_time = now();
                        $record->save();
                    }),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
