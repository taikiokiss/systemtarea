<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;


class ActuaVencida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actuavencida:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        \Log::info("Cron is working fine!");

        $registros = DB::table('tasks')->get();

        foreach ($registros as $registro) {
            $fechaEntrega = $registro->fecha_entrega;
            $fechaHoy = date("Y-m-d");

            if ($fechaHoy > $fechaEntrega) {
                Task::select(DB::table('tasks'))
                    ->where('id', $registro->id)
                    ->update([
                        'vencida' => 'SI'
                    ]);
            } else {}

        }
        
        $this->info('ActuaVencida:Cron Command Run successfully!');
    }
}
