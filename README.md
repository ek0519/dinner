# Lesson 1 Laravel Start and DB Schema Design

[![hackmd-github-sync-badge](https://hackmd.io/WeU4_6PuS1KgvE1CzyH87w/badge)](https://hackmd.io/WeU4_6PuS1KgvE1CzyH87w)


###### tags: `Laravel`

---

## 啟用Laravel

## 下載專案

https://github.com/ek0519/dinner

```bash=
git clone https://github.com/ek0519/dinner
```

----

## 設定 .env

```bash=
cp .env.example .env
```

## 啟用

安裝docker相關
```bash    
docker-compose build --no-cache
```
啟用 docker
```bash
docker-compose up
```

另外一個terminal 進入docker內部
```bash
docker-compose exec laravel bash
```

----

執行套件安裝
```bash
compsoer install
```

----

## 成功

http://127.0.0.1:8000/

![](https://i.imgur.com/dUYHr0n.png =600x)


---

## Laravel MVC架構
![](https://i.imgur.com/acfmL22.png =700x)



---


## 資料庫設計

----

### 資料型態


![](https://i.imgur.com/62QxwUq.jpg =600x)

[參考](https://www.mysqltutorial.org/mysql-data-types.aspx/) 

----

### [Primary Key](https://www.mysqltutorial.org/mysql-primary-key/)

> A primary key is a column or a set of columns that uniquely identifies each row in the table.  The primary key follows these rules:
> 1. A primary key must contain unique values
> 2. A primary key column cannot have NULL values.
> 3. A table can have one an only one primary key.

----

### [Foreign key](https://www.mysqltutorial.org/mysql-foreign-key/)

> A foreign key is a column or group of columns in a table that links to a column or group of columns in another table. 

![](https://i.imgur.com/1nOaGuy.png =300x)

----

### [UNIQUE Constraint](https://www.mysqltutorial.org/mysql-unique-constraint/)

> Sometimes, you want to ensure values in a column or a group of columns are unique. For example, email addresses of users in the users table, or phone numbers of customers in the customers table should be unique. To enforce this rule, you use a UNIQUE constraint.

----

### [NOT NULL Constraint](https://www.mysqltutorial.org/mysql-not-null-constraint/)

> The NOT NULL constraint is a column constraint that ensures values stored in a column are not NULL.

----

### [Schema diagram](https://docs.google.com/spreadsheets/d/1zVXo6KScV9tkyMXmqquF-1d1p_LL-CEMH_lGFhPKkxY/edit#gid=0)



#### [免費服務 dbdiagram](https://dbdiagram.io)
![](https://i.imgur.com/yeunB1O.png =600x)

[參考](https://dbdiagram.io/d/5fa6582c3a78976d7b7ae585)

---

## DB Relation

----

#### 一對一(one to one)

**user**資料表儘量和登入有關，其他欄位可以用 **user_info**，讓同屬一個資料分離常異動的資料。

----

#### 一對多或是多對一(one to many)

多種物品，單一歸屬，像是爸爸的拖鞋或是爸爸的汽車，有多樣東西，都屬於爸爸。

----

#### 多對多(many to many)
在博客來買書，所有的書可以被你買走，也可以被我買走

---

## [Laravel Defining Models( use Object–relational mapping)](https://laravel.com/docs/8.x/eloquent#defining-models)

簡化與資料庫的連線，透過model定義欄位與table與資料庫連線取得資料。

----

### 新增Modal

```bash=
php artisan make:model ModelName -參數
```
ModelName 通常用單數命名，產生出的table 以複數命名

----

#### 參數
* migration(定義資料庫變動)
**m**
* factory(假資料產生)
**f**
* seed(資料填充)
**s**
* controller(資料流程控制)
**c**

```bash=
php artisan make:model ModelName -mfs
```

---

## Eloquent Model Conventions
[參考](https://laravel.com/docs/8.x/eloquent#eloquent-model-conventions)
```php=
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    //
}
```

----

### fillable 
填寫資料寫入允許的欄位
```php=
protected $fillable = [
        'name',
        'email',
        'password',
    ];
```

----

### hidden
撈出資料時候預設不顯示
```php=
protected $hidden = [
        'password',
        'remember_token',
    ];
```

----

### casts
預設資料撈出來時的格式
```php=
protected $casts = [
        'email_verified_at' => 'datetime',
    ];
```

---


## migration

[參考](https://laravel.com/docs/8.x/migrations#creating-columns)

```php=
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}

```

----

## 同步資料庫

```php=
php artisan migrate
```

---

## 作業
1. 設計自己案子的schema，使用excel
2. 嘗試寫一個Modal與他的migration

## 報告
1. [laravel migration](https://laravel.com/docs/8.x/migrations#creating-columns)在設計 `作業`時用到的 `Column Types` 以及挑選原因
2. [run migration](https://laravel.com/docs/8.x/migrations#running-migrations) ":"後面參數的用法