<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // @canDo('create') ... @endCanDo
        Blade::directive('canDo', function (string $expression): string {
            return "<?php if (\\App\\Helpers\\PermissionHelper::can({$expression})): ?>";
        });

        Blade::directive('endCanDo', function (): string {
            return '<?php endif; ?>';
        });

        // @cantDo('create') ... @endCantDo
        Blade::directive('cantDo', function (string $expression): string {
            return "<?php if (!\\App\\Helpers\\PermissionHelper::can({$expression})): ?>";
        });

        Blade::directive('endCantDo', function (): string {
            return '<?php endif; ?>';
        });
    }
}
