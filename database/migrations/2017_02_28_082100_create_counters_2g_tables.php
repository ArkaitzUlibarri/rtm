<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounters2gTables extends Migration
{
    protected $tables = [
        'counters_2g_hour',
        'counters_2g_day',
        'counters_2g_controller_hour',
        'counters_2g_controller_day',
        'counters_2g_province_hour',
        'counters_2g_province_day',
    ];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::create('eri.' . $table, function (Blueprint $table) {
                $table->datetime('created_at');
                $table->integer('item_id');
                $table->smallinteger('c1')->nullable();
                $table->smallinteger('c2')->nullable();
                $table->smallinteger('c3')->nullable();
                $table->smallinteger('c4')->nullable();
                $table->smallinteger('c5')->nullable();
                $table->smallinteger('c6')->nullable();
                $table->smallinteger('c7')->nullable();
                $table->smallinteger('c8')->nullable();
                $table->smallinteger('c9')->nullable();
                $table->smallinteger('c10')->nullable();
                $table->smallinteger('c11')->nullable();
                $table->smallinteger('c12')->nullable();
                $table->smallinteger('c13')->nullable();
                $table->smallinteger('c14')->nullable();
                $table->smallinteger('c15')->nullable();
                $table->smallinteger('c16')->nullable();
                $table->smallinteger('c17')->nullable();
                $table->smallinteger('c18')->nullable();
                $table->smallinteger('c19')->nullable();
                $table->smallinteger('c20')->nullable();
                $table->smallinteger('c21')->nullable();
                $table->smallinteger('c22')->nullable();
                $table->smallinteger('c23')->nullable();
                $table->smallinteger('c24')->nullable();
                $table->smallinteger('c25')->nullable();
                $table->smallinteger('c26')->nullable();
                $table->smallinteger('c27')->nullable();
                $table->smallinteger('c28')->nullable();
                $table->smallinteger('c29')->nullable();
                $table->smallinteger('c30')->nullable();
                $table->smallinteger('c31')->nullable();
                $table->smallinteger('c32')->nullable();
                $table->smallinteger('c33')->nullable();
                $table->smallinteger('c34')->nullable();
                $table->smallinteger('c35')->nullable();
                $table->smallinteger('c36')->nullable();
                $table->smallinteger('c37')->nullable();
                $table->smallinteger('c38')->nullable();
                $table->smallinteger('c39')->nullable();
                $table->smallinteger('c40')->nullable();
                $table->smallinteger('c41')->nullable();
                $table->smallinteger('c42')->nullable();
                $table->smallinteger('c43')->nullable();
                $table->smallinteger('c44')->nullable();
                $table->smallinteger('c45')->nullable();
                $table->smallinteger('c46')->nullable();
                $table->smallinteger('c47')->nullable();
                $table->smallinteger('c48')->nullable();
                $table->smallinteger('c49')->nullable();
                $table->smallinteger('c50')->nullable();
                $table->smallinteger('c51')->nullable();
                $table->smallinteger('c52')->nullable();
                $table->smallinteger('c53')->nullable();
                $table->smallinteger('c54')->nullable();
                $table->smallinteger('c55')->nullable();
                $table->smallinteger('c56')->nullable();
                $table->smallinteger('c57')->nullable();
                $table->smallinteger('c58')->nullable();
                $table->smallinteger('c59')->nullable();
                $table->smallinteger('c60')->nullable();
                $table->smallinteger('c61')->nullable();
                $table->smallinteger('c62')->nullable();
                $table->smallinteger('c63')->nullable();
                $table->smallinteger('c64')->nullable();
                $table->smallinteger('c65')->nullable();
                $table->smallinteger('c66')->nullable();
                $table->smallinteger('c67')->nullable();
                $table->smallinteger('c68')->nullable();
                $table->smallinteger('c69')->nullable();
                $table->smallinteger('c70')->nullable();
                $table->smallinteger('c71')->nullable();
                $table->smallinteger('c72')->nullable();
                $table->smallinteger('c73')->nullable();
                $table->smallinteger('c74')->nullable();
                $table->smallinteger('c75')->nullable();
                $table->smallinteger('c76')->nullable();
                $table->smallinteger('c77')->nullable();
                $table->smallinteger('c78')->nullable();
                $table->smallinteger('c79')->nullable();
                $table->smallinteger('c80')->nullable();
                $table->smallinteger('c81')->nullable();
                $table->smallinteger('c82')->nullable();
                $table->smallinteger('c83')->nullable();
                $table->smallinteger('c84')->nullable();
                $table->smallinteger('c85')->nullable();
                $table->smallinteger('c86')->nullable();
                $table->smallinteger('c87')->nullable();
                $table->smallinteger('c88')->nullable();
                $table->smallinteger('c89')->nullable();
            });

            Schema::create('hua.' . $table, function (Blueprint $table) {
                $table->datetime('created_at')->nullable();
                $table->integer('item_id')->nullable();
                $table->smallinteger('c1')->nullable();
                $table->smallinteger('c2')->nullable();
                $table->smallinteger('c3')->nullable();
                $table->smallinteger('c4')->nullable();
                $table->smallinteger('c5')->nullable();
                $table->smallinteger('c6')->nullable();
                $table->smallinteger('c7')->nullable();
                $table->smallinteger('c8')->nullable();
                $table->smallinteger('c9')->nullable();
                $table->smallinteger('c10')->nullable();
                $table->smallinteger('c11')->nullable();
                $table->smallinteger('c12')->nullable();
                $table->smallinteger('c13')->nullable();
                $table->smallinteger('c14')->nullable();
                $table->smallinteger('c15')->nullable();
                $table->smallinteger('c16')->nullable();
                $table->smallinteger('c17')->nullable();
                $table->smallinteger('c18')->nullable();
                $table->smallinteger('c19')->nullable();
                $table->smallinteger('c20')->nullable();
                $table->smallinteger('c21')->nullable();
                $table->smallinteger('c22')->nullable();
                $table->smallinteger('c23')->nullable();
                $table->smallinteger('c24')->nullable();
                $table->smallinteger('c25')->nullable();
                $table->smallinteger('c26')->nullable();
                $table->smallinteger('c27')->nullable();
                $table->smallinteger('c28')->nullable();
                $table->smallinteger('c29')->nullable();
                $table->smallinteger('c30')->nullable();
                $table->smallinteger('c31')->nullable();
                $table->smallinteger('c32')->nullable();
                $table->smallinteger('c33')->nullable();
                $table->smallinteger('c34')->nullable();
                $table->smallinteger('c35')->nullable();
                $table->smallinteger('c36')->nullable();
                $table->smallinteger('c37')->nullable();
                $table->smallinteger('c38')->nullable();
                $table->smallinteger('c39')->nullable();
                $table->smallinteger('c40')->nullable();
                $table->smallinteger('c41')->nullable();
                $table->smallinteger('c42')->nullable();
                $table->smallinteger('c43')->nullable();
                $table->smallinteger('c44')->nullable();
                $table->smallinteger('c45')->nullable();
                $table->smallinteger('c46')->nullable();
                $table->smallinteger('c47')->nullable();
                $table->smallinteger('c48')->nullable();
                $table->smallinteger('c49')->nullable();
                $table->smallinteger('c50')->nullable();
                $table->smallinteger('c51')->nullable();
                $table->smallinteger('c52')->nullable();
                $table->smallinteger('c53')->nullable();
                $table->smallinteger('c54')->nullable();
                $table->smallinteger('c55')->nullable();
                $table->smallinteger('c56')->nullable();
                $table->smallinteger('c57')->nullable();
                $table->smallinteger('c58')->nullable();
                $table->smallinteger('c59')->nullable();
                $table->smallinteger('c60')->nullable();
                $table->smallinteger('c61')->nullable();
                $table->smallinteger('c62')->nullable();
                $table->smallinteger('c63')->nullable();
                $table->smallinteger('c64')->nullable();
                $table->smallinteger('c65')->nullable();
                $table->smallinteger('c66')->nullable();
                $table->smallinteger('c67')->nullable();
                $table->smallinteger('c68')->nullable();
                $table->smallinteger('c69')->nullable();
                $table->smallinteger('c70')->nullable();
                $table->smallinteger('c71')->nullable();
                $table->smallinteger('c72')->nullable();
                $table->smallinteger('c73')->nullable();
                $table->smallinteger('c74')->nullable();
                $table->smallinteger('c75')->nullable();
                $table->smallinteger('c76')->nullable();
                $table->smallinteger('c77')->nullable();
                $table->smallinteger('c78')->nullable();
                $table->smallinteger('c79')->nullable();
                $table->smallinteger('c80')->nullable();
                $table->smallinteger('c81')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::dropIfExists('eri.' . $table);
            Schema::dropIfExists('hua.' . $table);
        }
    }
}
