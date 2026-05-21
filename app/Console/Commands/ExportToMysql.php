<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/*
 * DEVBOOK — Migration SQLite → MySQL
 *
 * Lit toutes les données du SQLite local et génère
 * un fichier SQL compatible MySQL prêt à importer.
 *
 * Utilisation :
 *   php artisan trivy:export-mysql
 *   → crée database/export-mysql.sql
 *
 * Ensuite sur Railway :
 *   1. php artisan migrate --force
 *   2. mysql -h HOST -P PORT -u USER -pPASS DB < export-mysql.sql
 */
class ExportToMysql extends Command
{
    protected $signature   = 'trivy:export-mysql
                              {--output=database/export-mysql.sql : Chemin du fichier de sortie}';
    protected $description = 'Exporte les données SQLite vers un fichier SQL compatible MySQL';

    // Ordre respectant les clés étrangères
    private array $tables = [
        'users',
        'trips',
        'travellers',
        'checklist_items',
        'sessions',
        'cache',
    ];

    public function handle(): int
    {
        $outputPath = base_path($this->option('output'));

        $this->info('Lecture du SQLite…');

        $lines   = [];
        $lines[] = '-- ============================================';
        $lines[] = '-- Trivy — Export SQLite → MySQL';
        $lines[] = '-- Généré le ' . now()->format('d/m/Y à H:i:s');
        $lines[] = '-- ============================================';
        $lines[] = '';
        $lines[] = 'SET FOREIGN_KEY_CHECKS = 0;';
        $lines[] = 'SET NAMES utf8mb4;';
        $lines[] = '';

        foreach ($this->tables as $table) {
            try {
                $rows = DB::table($table)->get()->toArray();
            } catch (\Exception) {
                $this->warn("  ⚠ Table '$table' introuvable, ignorée.");
                continue;
            }

            $count   = count($rows);
            $lines[] = "-- ── $table ($count ligne(s)) ──";
            $lines[] = "TRUNCATE TABLE `$table`;";

            foreach ($rows as $row) {
                $row  = (array) $row;
                $cols = '`' . implode('`, `', array_keys($row)) . '`';
                $vals = implode(', ', array_map(
                    fn($v) => is_null($v) ? 'NULL' : "'" . addslashes((string) $v) . "'",
                    array_values($row)
                ));
                $lines[] = "INSERT INTO `$table` ($cols) VALUES ($vals);";
            }

            $lines[] = '';
            $this->line("  ✓ $table — $count ligne(s)");
        }

        $lines[] = 'SET FOREIGN_KEY_CHECKS = 1;';

        file_put_contents($outputPath, implode("\n", $lines));

        $size = round(filesize($outputPath) / 1024, 1);

        $this->newLine();
        $this->info("Export terminé → {$this->option('output')} ({$size} Ko)");
        $this->newLine();
        $this->line('<fg=yellow>Étapes suivantes :</>');
        $this->line('  1. Railway → ajouter plugin MySQL');
        $this->line('  2. <fg=cyan>php artisan migrate --force</> (sur Railway, en build)');
        $this->line('  3. Importer le fichier :');
        $this->line('     <fg=cyan>mysql -h HOST -P PORT -u USER -pPASS DATABASE < export-mysql.sql</>');

        return self::SUCCESS;
    }
}
