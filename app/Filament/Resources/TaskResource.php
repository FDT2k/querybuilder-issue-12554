<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\Constraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\Operators\Operator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('title'),
                TextColumn::make('completed'),
            ])
            ->filters([
                //

                QueryBuilder::make()
                ->constraints([
                   
                    Constraint::make('status')->operators([
                        Operator::make('status')
                            ->label(fn(bool $isInverse): string => $isInverse ? 'Done' : 'Not Done')
                            ->summary(fn(bool $isInverse): string => $isInverse ? 'Done' : 'Not Done')
                            ->baseQuery(fn(Builder $query, bool $isInverse) => $query->{$isInverse ? 'whereNotDone' : 'whereDone'}()),
                    ]),
                ])->constraintPickerColumns(2),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('make_me_crash')->form([
                    Placeholder::make('title')->default('Submit to make me crash'),
                ])->action(function (array $data) {
                    Notification::make()->title('If you see this, the bug is fixed :D or you didnt put a query builder constraint')->success()->send();
                })
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
            'index' => Pages\ManageTasks::route('/'),
        ];
    }
}
