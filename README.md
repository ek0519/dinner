# Lesson 4 ORM(2) and Insomnia
###### tags: `Laravel` `ORM` `Insomnia`

---

## Inserting & Updating Models

### Inserts

```php=
use App\Models\Flight;

$flight = new Flight;

$flight->name = $request->name;

$flight->save();
```

----

### Updates

```php=
$flight = App\Models\Flight::find(1);

$flight->name = 'New Flight Name';

$flight->save();
```

----

#### Mass Updates
```php=
App\Models\Flight::where('active', 1)
          ->where('destination', 'San Diego')
          ->update(['delayed' => 1]);
```

---

### Mass Assignment
```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
```    

----

If you would like to make all attributes mass assignable, you may define the $guarded property as an empty array:

```php=
protected $guarded = [];
```

---

## Other Creation Methods

### firstOrCreate/ firstOrNew

#### firstOrCreate
```php=
// Retrieve flight by name, or create it if it doesn't exist...
$flight = App\Models\Flight::firstOrCreate(['name' => 'Flight 10']);

// Retrieve flight by name, or create it with the name, delayed, and arrival_time attributes...
$flight = App\Models\Flight::firstOrCreate(
    ['name' => 'Flight 10'],
    ['delayed' => 1, 'arrival_time' => '11:30']
);

```

----

#### firstOrNew
```php=
// Retrieve by name, or instantiate...
$flight = App\Models\Flight::firstOrNew(['name' => 'Flight 10']);

// Retrieve by name, or instantiate with the name, delayed, and arrival_time attributes...
$flight = App\Models\Flight::firstOrNew(
    ['name' => 'Flight 10'],
    ['delayed' => 1, 'arrival_time' => '11:30']
);
```

----

#### Different

> Note that the model returned by firstOrNew has not yet been persisted to the database. You will need to call save manually to persist it:

---

### updateOrCreate

```php=
$flight = App\Models\Flight::updateOrCreate(
    ['departure' => 'Oakland', 'destination' => 'San Diego'],
    ['price' => 99, 'discounted' => 1]
);
```

---

## Deleting Models

### Deleting An Existing Model By Key

```php=
App\Models\Flight::destroy(1);

App\Models\Flight::destroy(1, 2, 3);

App\Models\Flight::destroy([1, 2, 3]);

App\Models\Flight::destroy(collect([1, 2, 3]));
```

----

### Deleting Models By Query

```php=
$deletedRows = App\Models\Flight::where('active', 0)->delete();
```

---

## Soft Deleting

```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use SoftDeletes;
}
```

----

## Querying Soft Deleted Models

**withTrashed**
```php=
$flights = App\Models\Flight::withTrashed()
                ->where('account_id', 1)
                ->get();
```

----

### Retrieving Only Soft Deleted Models

**onlyTrashed**
```php=
$flights = App\Models\Flight::onlyTrashed()
                ->where('airline_id', 1)
                ->get();
```

---

## Local Scopes

Local scopes allow you to define common sets of constraints that you may easily re-use throughout your application. For example, you may need to frequently retrieve all users that are considered "popular". To define a scope, prefix an Eloquent model method with scope.

----

```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->where('votes', '>', 100);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
```

----

and

```php=
$users = User::active()->get();
```
equal
```php=
$users = User::where('active', 1)->get();
```

----

### Dynamic Scopes

```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
```

----

Now, you may pass the parameters when calling the scope:

```php=
$users = App\Models\User::ofType('admin')->get();
```

---

## Database: Query Builder

### Inserts

```php=
DB::table('users')->insert([
    ['email' => 'taylor@example.com', 'votes' => 0],
    ['email' => 'dayle@example.com', 'votes' => 0],
]);
```

----

### Auto-Incrementing IDs

If the table has an auto-incrementing id, use the insertGetId method to insert a record and then retrieve the ID:

```php=
$id = DB::table('users')->insertGetId(
    ['email' => 'john@example.com', 'votes' => 0]
);
```

---

### Updates

```php=
$affected = DB::table('users')
              ->where('id', 1)
              ->update(['votes' => 1]);
```

----

#### Update Or Insert
```php=
DB::table('users')
    ->updateOrInsert(
        ['email' => 'john@example.com', 'name' => 'John'],
        ['votes' => '2']
    );
```

---

### Increment & Decrement

用於計算點閱次數

```php=
DB::table('users')->increment('votes');

DB::table('users')->increment('votes', 5);

DB::table('users')->decrement('votes');

DB::table('users')->decrement('votes', 5);
```

---

## Deletes

```php=
DB::table('users')->delete();

DB::table('users')->where('votes', '>', 100)->delete();
```

---

## [Insomnia](https://insomnia.rest/)

### download
![](https://i.imgur.com/MDya1h2.png =700x)

----

### Environment Variables

[參考](https://support.insomnia.rest/article/18-environment-variables)

---

## 作業

* 建立 UserControler與 MealController 的CRUD

## 讀書報告
* [Blade 1/2](https://laravel.com/docs/8.x/blade#introduction)