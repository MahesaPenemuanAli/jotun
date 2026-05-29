<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminMaintenanceController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (! $this->isEnabled()) {
            abort(404);
        }

        return view('admin.maintenance');
    }

    public function runMigrate(Request $request): RedirectResponse
    {
        if (! $this->isEnabled() || ! $this->verifyKey($request)) {
            abort(403, 'Maintenance key tidak valid atau fitur dinonaktifkan.');
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
        } catch (\Throwable $e) {
            return redirect()->route('admin.maintenance')
                ->with('error', 'Gagal migrate: ' . $e->getMessage());
        }

        return redirect()->route('admin.maintenance')
            ->with('success', 'Migration berhasil dijalankan.')
            ->with('log_output', $output);
    }

    public function runSeed(Request $request): RedirectResponse
    {
        if (! $this->isEnabled() || ! $this->verifyKey($request)) {
            abort(403, 'Maintenance key tidak valid atau fitur dinonaktifkan.');
        }

        try {
            set_time_limit(300);
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();
        } catch (\Throwable $e) {
            return redirect()->route('admin.maintenance')
                ->with('error', 'Gagal seed: ' . $e->getMessage());
        }

        return redirect()->route('admin.maintenance')
            ->with('success', 'Database seeding berhasil dijalankan.')
            ->with('log_output', $output);
    }

    private function isEnabled(): bool
    {
        return config('app.env') !== 'production'
            || filter_var(env('ENABLE_ADMIN_MAINTENANCE', false), FILTER_VALIDATE_BOOLEAN);
    }

    private function verifyKey(Request $request): bool
    {
        $configKey = env('MAINTENANCE_KEY', '');
        if (blank($configKey)) {
            return true; // No key set = allow in dev
        }
        return $request->input('maintenance_key') === $configKey;
    }
}
