# Тестовое задание для HiSmith

## RESTful API для управления заявками от дилеров на выдачу кредитов в автомобильной корпорации.

### Запуск и установка

- склонировать репозиторий;
- выполнить make start;

#### Доступные команды для make

##### composer:

- install
- validate

##### cocker-compose:

- make up
- make --build
- make stop

##### up && install:

- make start

##### test:

- make test

## Алгоритм

1. Настройка базу данных в файле .env:

```yml
DB_CONNECTION=mariadb
DB_HOST=db
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=password
```

1.2 Добавление MariaDB в `config/database.php`

```php
'connections' => [
    // ...
    'mariadb' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'forge'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
    ],
    // ...
],
```

2. Создание миграций для таблицы заявок и дилеров:

```php
docker-compose exec php php artisan make:migration create_applications_table --create=applications

docker-compose exec php php artisan make:migration create_dealerships_table --create=dealerships
```

3. Настройка миграций, чтобы добавить необходимые столбцы:

application_migrations:

```php
public function up()
{
    Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('dealer_id');
        $table->string('contact_person');
        $table->float('credit_amount');
        $table->integer('credit_term');
        $table->float('interest_rate');
        $table->text('reason_description');
        $table->string('status');
        $table->timestamps();
        
        $table->foreign('dealer_id')->references('id')->on('dealerships');
    });
}
```

dealerships_migrations:

```php
public function up()
{
    Schema::create('dealerships', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}
```

4. Выполнение миграции:

```php
docker-compose exec php php artisan migrate
```

5. Создание модели для заявок и дилеров:

```php
docker-compose exec php php artisan make:model Application

docker-compose exec php php artisan make:model Dealership
```

6. Определение связей между моделями в файлах Application.php и Dealership.php:

Application.php:

```php
public function dealership()
{
    return $this->belongsTo(Dealership::class);
}
```

Dealership.php:

```php
public function applications()
{
    return $this->hasMany(Application::class);
}
```

7. Создаем контроллер для API:

```php
docker-compose exec php php artisan make:controller ApplicationController
```

8. В контроллере ApplicationController определяем методы для создания, чтения, обновления и удаления заявок:

```php
use App\Application;

public function index()
{
    $applications = Application::paginate(10);
    return response()->json($applications);
}

public function store(Request $request)
{
    $application = new Application();
    $application->dealer_id = $request->dealer_id;
    $application->contact_person = $request->contact_person;
    $application->credit_amount = $request->credit_amount;
    $application->credit_term = $request->credit_term;
    $application->interest_rate = $request->interest_rate;
    $application->reason_description = $request->reason_description;
    $application->status = $request->status;
    $application->save();

    return response()->json($application, 201);
}

public function show($id)
{
    $application = Application::find($id);
    return response()->json($application);
}

public function update(Request $request, $id)
{
    $application = Application::find($id);
    $application->dealer_id = $request->dealer_id;
    $application->contact_person = $request->contact_person;
    $application->credit_amount = $request->credit_amount;
    $application->credit_term = $request->credit_term;
    $application->interest_rate = $request->interest_rate;
    $application->reason_description = $request->reason_description;
    $application->status = $request->status;
    $application->save();

    return response()->json($application);
}

public function destroy($id)
{
    $application = Application::find($id);
    $application->delete();

    return response()->json(null, 204);
}
```

9. Определяем маршруты в файле web.php:

```php
use App\Http\Controllers\ApplicationController;

Route::get('/applications', [ApplicationController::class, 'index']);
Route::post('/applications', [ApplicationController::class, 'store']);
Route::get('/applications/{id}', [ApplicationController::class, 'show']);
Route::put('/applications/{id}', [ApplicationController::class, 'update']);
Route::delete('/applications/{id}', [ApplicationController::class, '
destroy']);
```

10. Тестируем.