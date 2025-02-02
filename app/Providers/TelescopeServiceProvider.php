<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;
use Override;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        $isLocal = $this->app->environment('local');

        // @codeCoverageIgnoreStart
        Telescope::filter(function (IncomingEntry $entry) use ($isLocal): bool {
            return $isLocal ||
                $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
        // @codeCoverageIgnoreEnd
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    #[Override]
    protected function gate(): void
    {
        // @codeCoverageIgnoreStart
        Gate::define('viewTelescope', function (User $user): bool {
            return $user->email === config('project.telescope.allowed_email');
        });
        // @codeCoverageIgnoreEnd
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    private function hideSensitiveRequestDetails(): void
    {
        // @codeCoverageIgnoreStart
        if ($this->app->environment('local')) {
            return;
        }
        // @codeCoverageIgnoreEnd

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }
}
