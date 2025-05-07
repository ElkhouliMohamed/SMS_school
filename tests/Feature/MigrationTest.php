<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    public function test_students_table_exists()
    {
        $this->assertTrue(Schema::hasTable('students'));
        $this->assertTrue(Schema::hasColumn('students', 'first_name'));
        $this->assertTrue(Schema::hasColumn('students', 'deleted_at'));
    }

    public function test_subjects_table_exists()
    {
        $this->assertTrue(Schema::hasTable('subjects'));
        $this->assertTrue(Schema::hasColumn('subjects', 'name'));
    }
}
