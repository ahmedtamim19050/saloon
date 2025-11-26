<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Salon;

class UpdateHostsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hosts:update {--remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Windows hosts file with salon subdomains';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hostsFile = 'C:\Windows\System32\drivers\etc\hosts';
        
        if (!file_exists($hostsFile)) {
            $this->error('Hosts file not found!');
            return 1;
        }

        // Check if we have write permission
        if (!is_writable($hostsFile)) {
            $this->error('Cannot write to hosts file. Please run as Administrator:');
            $this->line('php artisan hosts:update');
            return 1;
        }

        $content = file_get_contents($hostsFile);
        
        // Remove old salon entries
        $content = preg_replace('/\n?# Salon Subdomains - Auto Generated\n.*?# End Salon Subdomains\n?/s', '', $content);
        
        if ($this->option('remove')) {
            file_put_contents($hostsFile, $content);
            $this->info('Removed all salon subdomain entries from hosts file.');
            return 0;
        }

        // Get all active salons with slugs
        $salons = Salon::whereNotNull('slug')
            ->where('status', 'active')
            ->pluck('slug');
        
        if ($salons->isEmpty()) {
            $this->warn('No salons with slugs found.');
            return 0;
        }

        // Build new entries
        $entries = "\n# Salon Subdomains - Auto Generated\n";
        foreach ($salons as $slug) {
            $entries .= "127.0.0.1 {$slug}.saloon.test\n";
        }
        $entries .= "# End Salon Subdomains\n";
        
        // Append to hosts file
        file_put_contents($hostsFile, $content . $entries);
        
        $this->info('Added ' . $salons->count() . ' salon subdomains to hosts file:');
        foreach ($salons as $slug) {
            $this->line("  → {$slug}.saloon.test");
        }
        
        $this->newLine();
        $this->comment('Please flush DNS cache:');
        $this->line('ipconfig /flushdns');
        
        return 0;
    }
}
