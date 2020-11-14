# Lesson 3 ORM(1) and Tinker

[![hackmd-github-sync-badge](https://hackmd.io/ev0nbH2GSV6amwT9kS9SHA/badge)](https://hackmd.io/ev0nbH2GSV6amwT9kS9SHA)

###### tags: `Laravel` `ORM` `Tinker` `Factory` `Seeder` `Where` `Select`

---

## Run Seed



```php=
php artisan db:seed
```

Command was excute which in this file.

```bash=
database/seeders/DatabaseSeeder.php
```

----

```php=
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MealSeeder::class
        ]);
    }
}

```

----

### seeder

`database/seeders/MealSeeder.php`

```php=
<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'meal_name' => '排骨飯',
                'price' => 70,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ],
            [
                'meal_name' => '雞腿飯',
                'price' => 90,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ],
            [
                'meal_name' => '蝦捲飯',
                'price' => 80,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ],
            [
                'meal_name' => '控肉飯',
                'price' => 70,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ]
        ];
        foreach ($data as $item) {
            Meal::create($item);
        }
    }
}

```

----

`database/seeders/UserSeeder.php`
```php=
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->times(20)
            ->create();
    }
}

```

----

### factory

`database/factories/UserFactory.php`
```php=
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'mobile' => $this->faker->phoneNumber,
            'status' => 1,
            'password' => Hash::make('Aa1234'),
            'remember_token' => Str::random(10),
        ];
    }
}

```

----

How to use Faker? 

`https://github.com/fzaninotto/Faker`


---

## Defining Models

### Table Names

```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'my_flights';
}
```

----

### Primary Keys

```php=
protected $primaryKey = 'flight_id';
```

n addition, Eloquent assumes that the primary key is an incrementing integer value, which means that by default the primary key will automatically be cast to an int. 

----

```php=
<?php

class Flight extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
```

----

If your primary key is not an integer, you should set the protected $keyType property on your model to string:

```php=
<?php

class Flight extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
```

----

### Timestamps

By default, Eloquent expects created_at and updated_at columns to exist on your tables. If you do not wish to have these columns automatically managed by Eloquent, set the $timestamps property on your model to false:

```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
```

----

### Default Attribute Values

If you would like to define the default values for some of your model's attributes, you may define an $attributes property on your model:

```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'delayed' => false,
    ];
}
```

----

## Retrieving Models

```php=
<?php

$flights = App\Models\Flight::all();

foreach ($flights as $flight) {
    echo $flight->name;
}
```

----

### Adding Additional Constraints

The Eloquent all method will return all of the results in the model's table. Since each Eloquent model serves as a query builder, you may also add constraints to queries, and then use the get method to retrieve the results:

```php=
$flights = App\Models\Flight::where('active', 1)
               ->orderBy('name', 'desc')
               ->take(10)
               ->get();
```

---

## Retrieving Single Models / Aggregates

In addition to retrieving all of the records for a given table, you may also retrieve single records using **find**, **first**, or **firstWhere**. Instead of returning a collection of models, these methods return a single model instance:

----

```php=
// Retrieve a model by its primary key...
$flight = App\Models\Flight::find(1);

// Retrieve the first model matching the query constraints...
$flight = App\Models\Flight::where('active', 1)->first();

// Shorthand for retrieving the first model matching the query constraints...
$flight = App\Models\Flight::firstWhere('active', 1);
```

----

You may also call the find method with an array of primary keys, which will return a collection of the matching records:
```php=
$flights = App\Models\Flight::find([1, 2, 3]);
```

----

### Not Found Exceptions

```php=
$model = App\Models\Flight::findOrFail(1);

$model = App\Models\Flight::where('legs', '>', 100)->firstOrFail();
```

----

If the exception is not caught, a 404 HTTP response is automatically sent back to the user. It is not necessary to write explicit checks to return **404** responses when using these methods:

```php=
Route::get('/api/flights/{id}', function ($id) {
    return App\Models\Flight::findOrFail($id);
});
```

----

### Retrieving Aggregates

You may also use the count, sum, max, and other [aggregate methods](https://laravel.com/docs/8.x/queries#aggregates) provided by the query builder. These methods return the appropriate scalar value instead of a full model instance:
```php=
$count = App\Models\Flight::where('active', 1)->count();

$max = App\Models\Flight::where('active', 1)->max('price');
```

---

## Database: Query Builder

```php=
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function index()
    {
        $users = DB::table('users')->get();

        return view('user.index', ['users' => $users]);
    }
}

```

----

The get method returns an Illuminate\Support\Collection containing the results where each result is an instance of the PHP stdClass object. You may access each column's value by accessing the column as a property of the object:

```php=
foreach ($users as $user) {
    echo $user->name;
}
```

----

If you don't even need an entire row, you may extract a single value from a record using the value method. This method will return the value of the column directly:

```php=
$email = DB::table('users')->where('name', 'John')->value('email');
```
To retrieve a single row by its id column value, use the find method:
```php=
$user = DB::table('users')->find(3);
```

----

### Retrieving A List Of Column Values

```php=
$titles = DB::table('roles')->pluck('title');

foreach ($titles as $title) {
    echo $title;
}

```
You may also specify a custom key column for the returned Collection:

```php=
$roles = DB::table('roles')->pluck('title', 'name');

foreach ($roles as $name => $title) {
    echo $title;
}
```
會以後面的當key `name`

----

### Chunking Results

If you need to work with thousands of database records, consider using the chunk method. This method retrieves a small chunk of the results at a time and feeds each chunk into a Closure for processing. This method is very useful for writing Artisan commands that process thousands of records. For example, let's work with the entire users table in chunks of 100 records at a time:
```php=
DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    foreach ($users as $user) {
        //
    }
});
```

---

## Selects

### Specifying A Select Clause
```php=
$users = DB::table('users')->select('name', 'email as user_email')->get();

User::select(['name', 'email'])->get();
```

----

If you already have a query builder instance and you wish to add a column to its existing select clause, you may use the addSelect method:
    

```php=
$query = DB::table('users')->select('name');

$users = $query->addSelect('age')->get();
```

---

## Where Clauses

### Simple Where Clauses
```php=
$users = DB::table('users')->where('votes', '=', 100)->get();
$users = DB::table('users')->where('votes', 'like','%' . 100 . '%')->get();
$users = DB::table('users')->where('votes', '<>', 100)->get();
$users = DB::table('users')->where('votes', '>=', 100)->get();

```

----

if has two condition

```php=
$users = DB::table('users')->where([
    ['status', '=', '1'],
    ['subscribed', '<>', '1'],
])->get();
```

----

### Or Statements

```php=
$users = DB::table('users')
                    ->where('votes', '>', 100)
                    ->orWhere('name', 'John')
                    ->get();
```

----

If you need to group an "or" condition within parentheses, you may pass a Closure as the first argument to the orWhere method:
```php=
$users = DB::table('users')
            ->where('votes', '>', 100)
            ->orWhere(function($query) {
                $query->where('name', 'Abigail')
                      ->where('votes', '>', 50);
            })
            ->get();

// SQL: select * from users where votes > 100 or (name = 'Abigail' and votes > 50)
```

----

### Additional Where Clauses
#### whereBetween / orWhereBetween
```php=
$users = DB::table('users')
           ->whereBetween('votes', [1, 100])
           ->get();
```

----

#### whereNotBetween / orWhereNotBetween
```php=
$users = DB::table('users')
                    ->whereNotBetween('votes', [1, 100])
                    ->get();
```

----

#### whereIn / whereNotIn / orWhereIn / orWhereNotIn

```php=
$users = DB::table('users')
                    ->whereIn('id', [1, 2, 3])
                    ->get();
```

```php=
$users = DB::table('users')
                    ->whereNotIn('id', [1, 2, 3])
                    ->get();
```

----

#### whereNull / whereNotNull / orWhereNull / orWhereNotNull

```php=
$users = DB::table('users')
                    ->whereNull('updated_at')
                    ->get();
```
```php=
$users = DB::table('users')
                    ->whereNotNull('updated_at')
                    ->get();
```

---

## Ordering, Grouping, Limit & Offset

### orderBy
```php=
$users = DB::table('users')
                ->orderBy('name', 'desc')
                ->orderBy('email', 'asc')
                ->get();
```

----

### latest / oldest

The latest and oldest methods allow you to easily order results by date. By default, result will be ordered by the **created_at** column. Or, you may pass the column name that you wish to sort by:

```php=
$user = DB::table('users')
                ->latest()
                ->first();
```

----

### groupBy / having

```php=
$users = DB::table('users')
                ->groupBy('account_id')
                ->having('account_id', '>', 100)
                ->get();
```
The having method's signature is similar to that of the where method:
 
---

## [Tinker](https://laravel.com/docs/8.x/artisan#tinker)

run 
```bash=
php artisan tinker
```

---

## 作業

1. 將 **MealSeeder** 寫死資料，抽換到 **MealFactory**，讓價格(price)亂數從 70, 80 ,90, 100 隨機分配價格，便當名稱從原有四種主餐加上飯麵與介於(100-999)之前的數字，例如: **排骨麵101**, **雞腿飯927**。
2. 將產生出的便當種類，透過ORM，用價格(price)，做出以價格為群組的撈取。

## 讀書報告
* [response](https://laravel.com/docs/8.x/responses)
