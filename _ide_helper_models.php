<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models {
    /**
     * App\Models\Admin
     *
     * @property int $id
     * @property int $role_id
     * @property string $pincode
     * @property string $user_name
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property string|null $deleted_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @property-read \App\Models\Role|null $role
     * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
     * @property-read int|null $tokens_count
     * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePincode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRoleId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserName($value)
     */
    class Admin extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Category
     *
     * @property int $id
     * @property int $parent_id
     * @property string $name
     * @property int $min_percent
     * @property int $max_percent
     * @property int $whole_percent
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
     * @property-read int|null $children_count
     * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $parents
     * @property-read int|null $parents_count
     * @method static \Database\Factories\CategoryFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
     * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Category query()
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereMaxPercent($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereMinPercent($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Category whereWholePercent($value)
     * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
     */
    class Category extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Login
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Login newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Login newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Login query()
     */
    class Login extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Postman
     *
     * @property int $id
     * @property string $full_name
     * @property string $phone
     * @property string $inn
     * @property string|null $description
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Warehouse_basket[] $Warehouse_basket
     * @property-read int|null $warehouse_basket_count
     * @method static \Illuminate\Database\Eloquent\Builder|Postman newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Postman newQuery()
     * @method static \Illuminate\Database\Query\Builder|Postman onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Postman query()
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereFullName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereInn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman wherePhone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Postman whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|Postman withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Postman withoutTrashed()
     */
    class Postman extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Product
     *
     * @property int $id
     * @property int $category_id
     * @property string $name
     * @property string $brand
     * @property float $cost_price
     * @property float $max_price
     * @property float $whole_price
     * @property float $min_price
     * @property string $unit
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \App\Models\Category|null $category
     * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
     * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Product query()
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrand($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereCostPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereMaxPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Product whereWholePrice($value)
     * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
     */
    class Product extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\ProductCode
     *
     * @property int $id
     * @property int $postman_id
     * @property int $product_id
     * @property int|null $warehouse_id
     * @property int|null $warehouse_basket_id
     * @property string $code
     * @property float $cost_price
     * @property float $count
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Warehouse_basket|null $basket
     * @property-read \App\Models\Postman|null $postman
     * @property-read \App\Models\Product|null $product
     * @property-read \App\Models\Warehouse|null $warehouse
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode query()
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereCostPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereCount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode wherePostmanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereProductId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereWarehouseBasketId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|ProductCode whereWarehouseId($value)
     */
    class ProductCode extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Role
     *
     * @property int $id
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role query()
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
     */
    class Role extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Transaction
     *
     * @property int $id
     * @property int $warehouse_basket_id
     * @property int $admin_id
     * @property string|null $description
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property string|null $deleted_at
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAdminId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereWarehouseBasketId($value)
     */
    class Transaction extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\User
     *
     * @property int $id
     * @property string $full_name
     * @property string $phone
     * @property string|null $inn
     * @property string $status
     * @property string|null $description
     * @property float $balance
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
     * @property-read int|null $tokens_count
     * @method static \Database\Factories\UserFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereFullName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereInn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|User withTrashed()
     * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
     */
    class User extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Warehouse
     *
     * @property int $id
     * @property int $postman_id
     * @property int $product_id
     * @property int $count
     * @property array $codes
     * @property string $date
     * @property int $active
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Product|null $product
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse query()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse setWarehouse(int $postman_id, int $product_id, int $count, string $code)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCodes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse wherePostmanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereProductId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereUpdatedAt($value)
     */
    class Warehouse extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Warehouse_basket
     *
     * @property int $id
     * @property int $admin_id
     * @property int $postman_id
     * @property float $usd_price
     * @property float $uzs_price
     * @property string|null $description
     * @property string|null $ordered_at
     * @property string|null $delivered_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property string|null $deleted_at
     * @property-read \App\Models\Admin|null $Admin
     * @property-read \App\Models\Postman|null $Postman
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Warehouse_order[] $orders
     * @property-read int|null $orders_count
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket query()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereAdminId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereDeliveredAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereIsDeliver($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereOrderedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket wherePostmanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereUsdPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_basket whereUzsPrice($value)
     */
    class Warehouse_basket extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Warehouse_order
     *
     * @property int $id
     * @property int $warehouse_basket_id
     * @property int $product_id
     * @property int $postman_id
     * @property int $count
     * @property string|null $code
     * @property int $get_count
     * @property string $unit
     * @property float $price
     * @property string|null $description
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property string|null $deleted_at
     * @property-read \App\Models\Warehouse_basket|null $basket
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Warehouse_basket[] $baskets
     * @property-read int|null $baskets_count
     * @property-read \App\Models\Product|null $product
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order query()
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereCount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereGetCount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order wherePostmanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereProductId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereUnit($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Warehouse_order whereWarehouseBasketId($value)
     */
    class Warehouse_order extends \Eloquent
    {
    }
}
