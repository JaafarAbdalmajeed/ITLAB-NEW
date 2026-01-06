<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            $this->upSqlite();
        } else {
            $this->upMySQL();
        }
    }

    /**
     * MySQL/MariaDB migration logic
     */
    private function upMySQL(): void
    {
        // Get the actual foreign key name
        $dbName = DB::getDatabaseName();
        
        try {
            $result = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'certificates' AND COLUMN_NAME = 'track_id' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1", [$dbName]);
            
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Drop foreign key constraint if it exists
            if (!empty($result)) {
                $fkName = $result[0]->CONSTRAINT_NAME;
                DB::statement("ALTER TABLE certificates DROP FOREIGN KEY `{$fkName}`;");
            }
            
            // Drop unique constraint if it exists
            try {
                DB::statement('ALTER TABLE certificates DROP INDEX certificates_user_id_track_id_unique;');
            } catch (\Exception $e) {
                // Index might not exist, continue
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {
            // If query fails, continue
        }
        
        // Add quiz_id first (as unsigned big integer, not foreignId to avoid constraint issues)
        // Check if column doesn't exist first
        if (!Schema::hasColumn('certificates', 'quiz_id')) {
            Schema::table('certificates', function (Blueprint $table) {
                $table->unsignedBigInteger('quiz_id')->nullable()->after('track_id');
            });
        }
        
        // Now modify track_id to be nullable using raw SQL
        // First ensure all track_id values reference valid tracks
        $validTrackIds = DB::table('tracks')->pluck('id')->toArray();
        if (!empty($validTrackIds)) {
            $placeholders = implode(',', array_fill(0, count($validTrackIds), '?'));
            DB::statement("UPDATE certificates SET track_id = NULL WHERE track_id IS NOT NULL AND track_id NOT IN ({$placeholders})", $validTrackIds);
        } else {
            // If no tracks exist, set all track_ids to NULL temporarily
            DB::statement('UPDATE certificates SET track_id = NULL WHERE track_id IS NOT NULL;');
        }
        
        // Modify track_id to nullable using raw SQL (disable FK checks temporarily)
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::statement('ALTER TABLE certificates MODIFY track_id BIGINT UNSIGNED NULL;');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {
            // If modification fails, continue
        }
        
        // Check if foreign key constraint exists and drop it first
        try {
            $trackFkResult = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'certificates' AND COLUMN_NAME = 'track_id' AND REFERENCED_TABLE_NAME = 'tracks' LIMIT 1", [DB::getDatabaseName()]);
            
            // Drop existing foreign key if it exists
            if (!empty($trackFkResult)) {
                $fkName = $trackFkResult[0]->CONSTRAINT_NAME;
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::statement("ALTER TABLE certificates DROP FOREIGN KEY `{$fkName}`;");
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        } catch (\Exception $e) {
            // If query fails, continue
        }
        
        // Clean up any orphaned data before adding constraint
        $validTrackIds = DB::table('tracks')->pluck('id')->toArray();
        if (!empty($validTrackIds)) {
            $placeholders = implode(',', array_fill(0, count($validTrackIds), '?'));
            DB::statement("UPDATE certificates SET track_id = NULL WHERE track_id IS NOT NULL AND track_id NOT IN ({$placeholders})", $validTrackIds);
        } else {
            DB::statement('UPDATE certificates SET track_id = NULL WHERE track_id IS NOT NULL;');
        }
        
        // Only add FK if it doesn't exist (using raw SQL to avoid issues)
        try {
            $trackFkCheck = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'certificates' AND COLUMN_NAME = 'track_id' AND REFERENCED_TABLE_NAME = 'tracks' LIMIT 1", [DB::getDatabaseName()]);
            
            if (empty($trackFkCheck)) {
                try {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::statement('ALTER TABLE certificates ADD CONSTRAINT certificates_track_id_foreign FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                } catch (\Exception $e) {
                    // If constraint addition fails, log and continue
                    \Log::warning('Failed to add track_id foreign key: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            // If query fails, continue
        }
        
        // Add foreign key constraint for quiz_id (using raw SQL)
        try {
            $quizFkResult = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'certificates' AND COLUMN_NAME = 'quiz_id' AND REFERENCED_TABLE_NAME = 'quizzes' LIMIT 1", [DB::getDatabaseName()]);
            if (empty($quizFkResult)) {
                // Clean up any orphaned data before adding constraint
                $validQuizIds = DB::table('quizzes')->pluck('id')->toArray();
                if (!empty($validQuizIds)) {
                    $placeholders = implode(',', array_fill(0, count($validQuizIds), '?'));
                    DB::statement("UPDATE certificates SET quiz_id = NULL WHERE quiz_id IS NOT NULL AND quiz_id NOT IN ({$placeholders})", $validQuizIds);
                } else {
                    DB::statement('UPDATE certificates SET quiz_id = NULL WHERE quiz_id IS NOT NULL;');
                }
                
                try {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::statement('ALTER TABLE certificates ADD CONSTRAINT certificates_quiz_id_foreign FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                } catch (\Exception $e) {
                    // If constraint addition fails, log and continue
                    \Log::warning('Failed to add quiz_id foreign key: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            // If query fails, continue
        }
        
        // Add unique constraints separately
        try {
            DB::statement('CREATE UNIQUE INDEX certificates_user_track_unique ON certificates(user_id, track_id);');
        } catch (\Exception $e) {
            // Index might already exist
        }
        
        try {
            DB::statement('CREATE UNIQUE INDEX certificates_user_quiz_unique ON certificates(user_id, quiz_id);');
        } catch (\Exception $e) {
            // Index might already exist
        }
    }

    /**
     * SQLite migration logic
     */
    private function upSqlite(): void
    {
        // SQLite has limited ALTER TABLE support
        // We'll add the quiz_id column and constraints, but won't modify track_id nullability
        // (SQLite requires table recreation to change column nullability, which is complex)
        
        // Add quiz_id column (SQLite doesn't support 'after' clause, so we omit it)
        if (!Schema::hasColumn('certificates', 'quiz_id')) {
            Schema::table('certificates', function (Blueprint $table) {
                $table->unsignedBigInteger('quiz_id')->nullable();
            });
        }
        
        // Clean up any orphaned data
        $validQuizIds = DB::table('quizzes')->pluck('id')->toArray();
        if (!empty($validQuizIds)) {
            $placeholders = implode(',', array_fill(0, count($validQuizIds), '?'));
            DB::statement("UPDATE certificates SET quiz_id = NULL WHERE quiz_id IS NOT NULL AND quiz_id NOT IN ({$placeholders})", $validQuizIds);
        }
        
        // Drop old unique constraint if it exists (try different possible names)
        $indexNames = [
            'certificates_user_id_track_id_unique',
            'certificates_user_id_track_id_unique_index',
        ];
        
        foreach ($indexNames as $indexName) {
            try {
                DB::statement("DROP INDEX IF EXISTS {$indexName}");
            } catch (\Exception $e) {
                // Continue if it doesn't exist
            }
        }
        
        // Add unique constraints using Schema builder (handles SQLite better)
        Schema::table('certificates', function (Blueprint $table) {
            try {
                $table->unique(['user_id', 'track_id'], 'certificates_user_track_unique');
            } catch (\Exception $e) {
                // Index might already exist
            }
            
            try {
                $table->unique(['user_id', 'quiz_id'], 'certificates_user_quiz_unique');
            } catch (\Exception $e) {
                // Index might already exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            $this->downSqlite();
        } else {
            $this->downMySQL();
        }
    }

    /**
     * MySQL/MariaDB rollback logic
     */
    private function downMySQL(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Drop new constraints
            try {
                $table->dropUnique('certificates_user_track_unique');
            } catch (\Exception $e) {
                // Might not exist
            }
            
            try {
                $table->dropUnique('certificates_user_quiz_unique');
            } catch (\Exception $e) {
                // Might not exist
            }
            
            // Drop quiz_id
            try {
                $table->dropForeign(['quiz_id']);
            } catch (\Exception $e) {
                // Might not exist
            }
            
            if (Schema::hasColumn('certificates', 'quiz_id')) {
                $table->dropColumn('quiz_id');
            }
            
            // Make track_id not nullable again
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::statement('ALTER TABLE certificates MODIFY track_id BIGINT UNSIGNED NOT NULL;');
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (\Exception $e) {
                // If modification fails, continue
            }
            
            // Restore old unique constraint
            try {
                $table->unique(['user_id', 'track_id']);
            } catch (\Exception $e) {
                // Might already exist
            }
        });
    }

    /**
     * SQLite rollback logic
     */
    private function downSqlite(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Drop new constraints
            try {
                $table->dropUnique('certificates_user_track_unique');
            } catch (\Exception $e) {
                // Might not exist
            }
            
            try {
                $table->dropUnique('certificates_user_quiz_unique');
            } catch (\Exception $e) {
                // Might not exist
            }
            
            // Drop quiz_id foreign key and column
            try {
                $table->dropForeign(['quiz_id']);
            } catch (\Exception $e) {
                // Might not exist
            }
            
            if (Schema::hasColumn('certificates', 'quiz_id')) {
                $table->dropColumn('quiz_id');
            }
            
            // Restore old unique constraint
            try {
                $table->unique(['user_id', 'track_id']);
            } catch (\Exception $e) {
                // Might already exist
            }
        });
    }
};
