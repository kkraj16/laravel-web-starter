# Advanced Product & Category Implementation Plan

## Goal
Upgrade the existing simple Product and Category modules to a fully-featured, enterprise-grade e-commerce system as per the "Product Owner" detailed requirements. This includes SEO, soft deletes, variable products, and advanced inventory management.

## User Review Required
> [!IMPORTANT]
> **Breaking Schema Changes**: I will be modifying the `products` and `categories` tables significantly.
> - **Categories**: Adding `icon`, `position`, `meta_*`, `deleted_at`.
> - **Products**: Converting `category_id` to a pivot table `product_categories` (Many-to-Many).
> - **Variants**: Creating a new `product_variants` table.
> - **Images**: Moving from `ProductImage` model to a simpler JSON `gallery` column in `products` (as per req) OR keeping the relation if preferred. *Plan: Keep relation for better flexibility but add `thumbnail` column.*

## Proposed Changes

### Database Schema (Migrations)

#### 1. Consolidate/Update `categories` table
- Add `icon`, `position` (default 0), `meta_title`, `meta_description`, `meta_keywords`.
- Add `deleted_at` (SoftDeletes).

#### 2. Update `products` table
- Add `short_description`, `product_type` (enum: simple, variable, digital), `brand_id` (nullable).
- Add `sale_start`, `sale_end`, `tax_class`.
- Add `manage_stock` (boolean), `stock_status` (enum).
- Add `thumbnail` (string), `gallery` (json) - *Will likely sync this with `ProductImage` model*.
- Add `meta_title`, `meta_description`, `meta_keywords`.
- Add `deleted_at`.
- Drop `category_id` (migrating data to pivot first).

#### 3. Create `product_categories` pivot table
- `product_id`, `category_id`.

#### 4. Create `product_variants` table
- `product_id`, `sku`, `price`, `stock`, `attributes` (JSON).

### Models
- **Category**: Add `SoftDeletes`, `position` scope, `products()` (belongsToMany).
- **Product**: Add `SoftDeletes`, `categories()` (belongsToMany), `variants()` (hasMany).
- **ProductVariant**: New Model.

### Admin Features (Controllers & Views)
- **CategoryController**:
    - Update `store/update` to handle SEO fields.
    - Implement `reorder` (position) logic (future phase or simple input for now).
- **ProductController**:
    - **Create/Edit**:
        - **Tabs**: General, Pricing, Inventory, Images, SEO, Variants.
        - **Category Tree**: Select multiple categories.
        - **Variant Generator**: UI to add size/color variations (Phase 1: Simple JSON or separate lines).

---

## Verification Plan
1.  **Schema Check**: Run `php artisan migrate:fresh --seed` (if acceptable) or incremental migrations.
2.  **CRUD Test**: Create a "Variable Product" with multiple categories and SEO tags.
3.  **UI Verification**: Check AdminLTE tabs and form fields.
