# System Patterns: Modular and Service-Driven Architecture

## 1. Core Architectural Model

The system is built upon a **modular monolith** architecture. While it operates as a single application, its internal structure is divided into discrete, independent plugins. This approach combines the deployment simplicity of a monolith with the maintainability and scalability of a microservices-like design.

## 2. Key Design Patterns

-   **Plugin Architecture:** The primary pattern is the use of self-contained plugins located in `plugins/webkul/`. Each plugin encapsulates a specific business domain (e.g., `products`, `sales`, `invoices`) and includes its own routes, controllers, models, and views.
-   **Service Provider Model:** Laravel's Service Providers are used extensively to register plugin services, routes, and other resources with the main application. Each plugin has its own `PluginServiceProvider`.
-   **Repository Pattern:** (Assumed) Given the complexity of an ERP, it's likely that a repository pattern is used to abstract the data layer, promoting a separation of concerns between business logic and data access.
-   **Multi-Tenancy (Potential):** While not explicitly confirmed, ERP systems often require multi-tenancy. The architecture should be evaluated for this possibility. The presence of a `CustomerPanelProvider` might also hint at this.

## 3. Component Relationships

-   **Core Application:** The `app/` directory contains the core application logic, which acts as the central orchestrator. It provides the foundational services and bootstraps the plugins.
-   **Plugins:** The `plugins/` directory contains the feature modules. These are loosely coupled with the core application and potentially with each other.
-   **Admin Panels:** The `app/Providers/Filament/` directory defines the Filament admin panels. These panels consume services and data from the core application and the plugins to build the user interface.

## 4. Critical Implementation Paths

-   **Plugin Registration:** Understanding how plugins are registered and booted is critical for adding new modules or modifying existing ones. This is handled in `bootstrap/plugins.php` and `bootstrap/providers.php`.
-   **Data Flow:** Tracing the flow of data between plugins and the core application is essential for understanding business processes.
-   **Permissions & Access Control:** The integration with `filament-shield` and `spatie/laravel-permission` is a critical path for ensuring system security.

---

# Plugin Architecture Deep Dive

This section provides a comprehensive guide to the plugin system, from creation to detailed implementation of its various components.

## 5. Creating a New Plugin

### 5.1. Directory Structure

First, create a new plugin directory inside `plugins/` using **kebab-case** for the folder name. Each plugin should follow this structure:

```plaintext
plugins/
└── my-new-plugin/
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   ├── seeders/
    │   └── settings/
    ├── resources/
    │   ├── views/
    │   └── lang/
    ├── src/
    │   ├── Filament/
    │   │   ├── Admin/
    │   │   └── Customer/
    │   ├── Models/
    │   ├── Policies/
    │   ├── Routes/
    │   │   ├── web.php
    │   │   └── api.php
    │   ├── Services/
    │   ├── MyNewPlugin.php         # Filament registration
    │   └── MyNewPluginServiceProvider.php # Bootstrapping
    ├── config/
    ├── tests/
    ├── .gitignore
    ├── composer.json
    ├── package.json
    ├── postcss.config.js
    └── tailwind.config.js
```

### 5.2. `composer.json` Setup

Create a `composer.json` file for the plugin. This file enables Laravel to auto-discover the plugin's service provider and autoload its classes.

```json
{
  "name": "webkul/blogs",
  "description": "Blog posts management for Aureus ERP",
  "authors": [
    {
      "name": "Aureus ERP",
      "email": "support@aureuserp.in"
    }
  ],
  "extra": {
    "laravel": {
      "providers": ["Webkul\\Blog\\BlogServiceProvider"],
      "aliases": {}
    }
  },
  "autoload": {
    "psr-4": {
      "Webkul\\Blog\\": "src/",
      "Webkul\\Blog\\Database\\Factories\\": "database/factories/",
      "Webkul\\Blog\\Database\\Seeders\\": "database/seeders/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "Webkul\\Blog\\Tests\\": "tests/"
    }
  }
}
```

> **Note:** Ensure the namespaces and paths in `composer.json` match your plugin's structure.

## 6. Core Plugin Components & Registration

### 6.1. The Service Provider (`BlogServiceProvider.php`)

The Service Provider is the **main entry point** for a plugin. It registers migrations, settings, dependencies, assets, and installation/uninstallation logic.

-   **Location:** `src/BlogServiceProvider.php`

```php
<?php

namespace Webkul\Blog;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Webkul\Support\Console\Commands\InstallCommand;
use Webkul\Support\Console\Commands\UninstallCommand;
use Webkul\Support\Package;
use Webkul\Support\PackageServiceProvider;

class BlogServiceProvider extends PackageServiceProvider
{
    public static string $name = 'blogs';
    public static string $viewNamespace = 'blogs';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2025_03_06_093011_create_blogs_categories_table',
                '2025_03_06_094011_create_blogs_posts_table',
            ])
            ->runsMigrations()
            ->hasSettings([
                '2025_03_12_111247_create_blogs_posts_settings'
            ])
            ->runsSettings()
            ->hasDependencies(['website'])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->installDependencies()->runsMigrations();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {});
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('blogs', __DIR__.'/../resources/dist/blogs.css'),
        ], 'blogs');
    }
}
```

**Key Configuration Methods:**

| Method | Purpose |
| :--- | :--- |
| `hasViews()` | Loads Blade templates from `resources/views/`. |
| `hasTranslations()` | Loads translations from `resources/lang/`. |
| `hasMigrations([...])` | Registers DB migration files. |
| `runsMigrations()` | Executes migrations during installation. |
| `hasSettings([...])` | Registers plugin-specific settings migrations. |
| `runsSettings()` | Executes settings migrations during installation. |
| `hasDependencies([...])` | Ensures required plugins are installed first. |
| `hasInstallCommand()` | Defines logic for plugin installation. |
| `hasUninstallCommand()` | Defines cleanup logic for uninstallation. |
| `hasSeeder(...)` | Registers a database seeder class. |

### 6.2. The Filament Plugin Class (`BlogPlugin.php`)

This class integrates the plugin with Filament, dynamically registering resources, pages, clusters, and widgets based on the active panel (`admin` or `customer`).

-   **Location:** `src/BlogPlugin.php`

```php
<?php

namespace Webkul\Blog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Webkul\Support\Package;

class BlogPlugin implements Plugin
{
    public function getId(): string
    {
        return 'blogs';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        if (! Package::isPluginInstalled($this->getId())) {
            return;
        }

        $panel
            ->when($panel->getId() == 'customer', function (Panel $panel) {
                $panel
                    ->discoverResources(in: $this->getPluginBasePath('/Filament/Customer/Resources'), for: 'Webkul\\Blog\\Filament\\Customer\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Customer/Pages'), for: 'Webkul\\Blog\\Filament\\Customer\\Pages');
            })
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel
                    ->discoverResources(in: $this->getPluginBasePath('/Filament/Admin/Resources'), for: 'Webkul\\Blog\\Filament\\Admin\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Admin/Pages'), for: 'Webkul\\Blog\\Filament\\Admin\\Pages');
            });
    }

    public function boot(Panel $panel): void
    {
        // Custom logic during plugin boot
    }

    protected function getPluginBasePath(string $path = null): string
    {
        $reflector = new \ReflectionClass(get_class($this));
        return dirname($reflector->getFileName()) . ($path ?? '');
    }
}
```

### 6.3. Plugin Registration

To activate the plugin, register its Service Provider and Plugin class in the corresponding bootstrap files:

1.  **Register Service Provider** in `bootstrap/providers.php`:
    ```php
    return [
        // Other service providers
        Webkul\Blog\BlogServiceProvider::class,
    ];
    ```
2.  **Register Plugin Class** in `bootstrap/plugins.php`:
    ```php
    return [
        // Other plugins
        Webkul\Blog\BlogPlugin::class,
    ];
    ```

---

## 7. Plugin Directory Deep Dive

### 7.1. The `database/` Directory

Manages all database-related functionality for a plugin.

#### `migrations/`

Migrations provide a version-controlled approach to evolving your database schema.

1.  **Create a migration:**
    ```bash
    php artisan make:migration create_posts_table
    ```
2.  **Move it** to `plugins/your-plugin/database/migrations/`.
3.  **Register it** in your `ServiceProvider` using `hasMigrations(['create_posts_table'])`. The `runsMigrations()` method ensures it executes on install.

#### `factories/`

Factories generate fake data for testing or seeding.

1.  **Link the factory** in your model:
    ```php
    // Webkul\Blogs\Models\Post.php
    use Webkul\Blogs\Database\Factories\PostFactory;

    protected static function newFactory()
    {
        return PostFactory::new();
    }
    ```
2.  **Define the factory:**
    ```php
    // plugins/blogs/database/factories/PostFactory.php
    namespace Webkul\Blogs\Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use Webkul\Blogs\Models\Post;

    class PostFactory extends Factory
    {
        protected $model = Post::class;

        public function definition(): array
        {
            return [
                'title' => $this->faker->sentence,
                'content' => $this->faker->paragraphs(3, true),
            ];
        }
    }
    ```

#### `seeders/`

Seeders pre-populate tables with default or test data.

1.  **Create a seeder:** `php artisan make:seeder PostSeeder`
2.  **Move it** to `plugins/your-plugin/database/seeders/` and update the namespace.
3.  **Define the `run` method** to insert data.
4.  **Call it** from a main `DatabaseSeeder.php` within your plugin.
5.  **Register the main seeder** in your `ServiceProvider`:
    ```php
    ->hasSeeder('Webkul\\Blog\\Database\\Seeders\\DatabaseSeeder')
    ```

#### `settings/`

Store dynamic, type-safe configuration using **Spatie Laravel Settings**.

1.  **Create a Settings Class:**
    ```php
    // src/Settings/PostSettings.php
    use Spatie\LaravelSettings\Settings;

    class PostSettings extends Settings
    {
        public bool $enable_comments;
        public bool $require_approval_for_comments;

        public static function group(): string
        {
            return 'blogs_posts';
        }
    }
    ```
2.  **Create a Settings Migration:**
    ```bash
    php artisan make:settings-migration create_blogs_posts_settings
    ```
3.  **Move it** to `database/settings/` and define default values.
4.  **Register it** in your `ServiceProvider` with `hasSettings([...])` and `runsSettings()`.

### 7.2. The `resources/` Directory

Contains views and language files.

-   **`views/`**: Store Blade templates here. Access them using the view namespace, e.g., `view('blogs::index')`.
-   **`lang/`**: Store translation files in locale-specific subdirectories (e.g., `en/`, `es/`). Access translations with the namespace, e.g., `__('blogs::messages.welcome')`.

### 7.3. The `src/` Directory

This directory holds the core PHP source code for the plugin.

#### `Models/`

Models define database entities and encapsulate Eloquent ORM logic.

```php
// src/Models/Post.php
namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'author_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
```

#### `Policies/`

Policies manage authorization rules for models. Filament auto-discovers a `ModelPolicy` if it's in the same namespace as the model.

```php
// src/Policies/PostPolicy.php
namespace Webkul\Blogs\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Blogs\Models\Post;
use Modules\Security\Models\User;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_post');
    }

    public function view(User $user, Post $post): bool
    {
        return $user->can('view_post');
    }
    // ... other policy methods
}
```

#### `Filament/`

This directory organizes all Filament components, separated by panel (`Admin` and `Customer`). The `BlogPlugin` class automatically discovers and registers resources, pages, and widgets from these directories.

```plaintext
src/Filament/
├── Admin/
│   ├── Resources/
│   ├── Pages/
│   ├── Clusters/
│   └── Widgets/
└── Customer/
    ├── Resources/
    ├── Pages/
    ├── Clusters/
    └── Widgets/
