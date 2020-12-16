<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Enums\SettingKey;

class MigrateSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the setting keys';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Migrating setting...');

        $count = count(SettingKey::getValues());
        $this->output->progressStart($count);

        foreach (SettingKey::getValues() as $key) {
            $setting = Setting::firstOrCreate(
                ['key' => $key],
                ['key' => $key, 'value' => '']
            );
        }

        $this->output->progressFinish();
        $this->info('Migrating setting successfully!');
    }
}
