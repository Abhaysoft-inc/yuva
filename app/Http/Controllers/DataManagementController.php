<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;
use ZipArchive;

class DataManagementController extends Controller
{
    public function exportMembersCsv()
    {
        $filename = 'members-export-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');

            fputcsv($out, [
                'member_id',
                'member_code',
                'name',
                'husband_father_name',
                'role',
                'mobile',
                'date_of_birth',
                'blood_group',
                'aadhar_number',
                'pan_number',
                'address',
                'bank_name',
                'branch',
                'account_number',
                'ifsc_code',
                'status',
                'verification_status',
                'valid_from',
                'valid_to',
                'shg_id',
                'shg_name',
                'shg_code',
                'created_at',
                'updated_at',
            ]);

            DB::table('members')
                ->leftJoin('shgs', 'members.shg_id', '=', 'shgs.id')
                ->select([
                    'members.id as member_id',
                    'members.member_id_code',
                    'members.name',
                    'members.husband_father_name',
                    'members.role',
                    'members.mobile',
                    'members.date_of_birth',
                    'members.blood_group',
                    'members.aadhar_number',
                    'members.pan_number',
                    'members.address',
                    'members.bank_name',
                    'members.branch',
                    'members.account_number',
                    'members.ifsc_code',
                    'members.status',
                    'members.verification_status',
                    'members.valid_from',
                    'members.valid_to',
                    'members.shg_id',
                    'shgs.shg_name',
                    'shgs.shg_code',
                    'members.created_at',
                    'members.updated_at',
                ])
                ->orderBy('members.id')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $row) {
                        fputcsv($out, (array) $row);
                    }
                });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportShgsCsv()
    {
        $filename = 'shgs-export-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');

            fputcsv($out, [
                'id',
                'shg_name',
                'shg_code',
                'shg_contact',
                'date_of_formation',
                'village',
                'pincode',
                'address',
                'state',
                'district',
                'president_name',
                'president_contact',
                'secretary_name',
                'secretary_contact',
                'treasurer_name',
                'treasurer_contact',
                'bank_account_number',
                'bank_name',
                'ifsc_code',
                'branch_name',
                'fd_security_money',
                'meeting_frequency',
                'monthly_saving_amount',
                'status',
                'declaration_accepted',
                'created_at',
                'updated_at',
            ]);

            DB::table('shgs')
                ->select([
                    'id',
                    'shg_name',
                    'shg_code',
                    'shg_contact',
                    'date_of_formation',
                    'village',
                    'pincode',
                    'address',
                    'state',
                    'district',
                    'president_name',
                    'president_contact',
                    'secretary_name',
                    'secretary_contact',
                    'treasurer_name',
                    'treasurer_contact',
                    'bank_account_number',
                    'bank_name',
                    'ifsc_code',
                    'branch_name',
                    'fd_security_money',
                    'meeting_frequency',
                    'monthly_saving_amount',
                    'status',
                    'declaration_accepted',
                    'created_at',
                    'updated_at',
                ])
                ->orderBy('id')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $row) {
                        fputcsv($out, (array) $row);
                    }
                });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportAllCsvZip()
    {
        $zipPath = tempnam(sys_get_temp_dir(), 'ngo_csv_') . '.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not create export archive.');
        }

        $tables = $this->getAllTables();
        foreach ($tables as $table) {
            $zip->addFromString($table . '.csv', $this->tableAsCsv($table));
        }

        $zip->addFromString('metadata.json', json_encode([
            'generated_at' => now()->toIso8601String(),
            'table_count' => count($tables),
            'tables' => $tables,
        ], JSON_PRETTY_PRINT));

        $zip->close();

        return response()->download(
            $zipPath,
            'ngo-all-csv-export-' . now()->format('Ymd-His') . '.zip'
        )->deleteFileAfterSend(true);
    }

    public function backupAllData()
    {
        $backup = $this->buildBackupPayload();

        $filename = 'ngo-backup-' . now()->format('Ymd-His') . '.json';

        return response()->streamDownload(function () use ($backup) {
            echo json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }

    public function restoreBackup(Request $request)
    {
        $validated = $request->validate([
            'backup_file' => 'required|file|mimes:json,txt|max:51200',
        ]);

        try {
            $content = file_get_contents($validated['backup_file']->getRealPath());
            $payload = json_decode($content ?: '', true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            return back()->with('error', 'Invalid backup file. Please upload a valid JSON backup.');
        }

        if (!isset($payload['tables']) || !is_array($payload['tables'])) {
            return back()->with('error', 'Backup file format is invalid. Missing tables payload.');
        }

        $existingTables = collect($this->getAllTables());
        $backupTables = collect(array_keys($payload['tables']));
        $unknownTables = $backupTables->diff($existingTables)->values();

        if ($unknownTables->isNotEmpty()) {
            return back()->with('error', 'Restore blocked: backup contains unknown tables for this database.');
        }

        $safetySnapshot = 'backups/pre-restore-' . now()->format('Ymd-His') . '.json';
        Storage::disk('local')->put(
            $safetySnapshot,
            json_encode($this->buildBackupPayload(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        DB::beginTransaction();

        try {
            $this->disableForeignKeyChecks();

            foreach (array_reverse($backupTables->all()) as $table) {
                $this->truncateTable($table);
            }

            foreach ($payload['tables'] as $table => $rows) {
                if (!is_array($rows) || !$existingTables->contains($table) || empty($rows)) {
                    continue;
                }

                $columns = Schema::getColumnListing($table);
                $insertRows = [];

                foreach ($rows as $row) {
                    if (!is_array($row)) {
                        continue;
                    }

                    $filtered = [];
                    foreach ($columns as $column) {
                        if (array_key_exists($column, $row)) {
                            $filtered[$column] = $row[$column];
                        }
                    }

                    if (!empty($filtered)) {
                        $insertRows[] = $filtered;
                    }
                }

                foreach (array_chunk($insertRows, 500) as $chunk) {
                    DB::table($table)->insert($chunk);
                }
            }

            $this->enableForeignKeyChecks();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            $this->enableForeignKeyChecks();

            return back()->with('error', 'Restore failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Backup restored successfully. Safety snapshot saved to storage/app/' . $safetySnapshot);
    }

    private function tableAsCsv(string $table): string
    {
        $columns = Schema::getColumnListing($table);
        $stream = fopen('php://temp', 'r+');
        fputcsv($stream, $columns);

        DB::table($table)
            ->orderBy($this->sortableColumn($table))
            ->chunk(500, function ($rows) use ($stream, $columns) {
                foreach ($rows as $row) {
                    $record = (array) $row;
                    $csvRow = [];

                    foreach ($columns as $column) {
                        $csvRow[] = $record[$column] ?? null;
                    }

                    fputcsv($stream, $csvRow);
                }
            });

        rewind($stream);
        $content = stream_get_contents($stream);
        fclose($stream);

        return $content ?: '';
    }

    private function sortableColumn(string $table): string
    {
        $columns = Schema::getColumnListing($table);

        return in_array('id', $columns, true) ? 'id' : $columns[0];
    }

    private function getAllTables(): array
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            $tables = DB::select('SHOW TABLES');
            $key = 'Tables_in_' . DB::getDatabaseName();

            return array_map(static fn ($table) => $table->{$key}, $tables);
        }

        if ($driver === 'sqlite') {
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            return array_map(static fn ($table) => $table->name, $tables);
        }

        if ($driver === 'pgsql') {
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            return array_map(static fn ($table) => $table->tablename, $tables);
        }

        return Schema::getTableListing();
    }

    private function buildBackupPayload(): array
    {
        $tables = $this->getAllTables();
        $backup = [
            'generated_at' => now()->toIso8601String(),
            'database' => config('database.default'),
            'tables' => [],
        ];

        foreach ($tables as $table) {
            $backup['tables'][$table] = DB::table($table)->get()->map(fn ($row) => (array) $row)->all();
        }

        return $backup;
    }

    private function disableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            return;
        }

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        }
    }

    private function enableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return;
        }

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }
    }

    private function truncateTable(string $table): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('TRUNCATE TABLE "' . $table . '" RESTART IDENTITY CASCADE');
            return;
        }

        DB::table($table)->truncate();
    }
}
