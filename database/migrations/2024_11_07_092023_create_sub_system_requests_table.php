<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSystemRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_system_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('material_cost')->nullable();
            $table->string('location')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment = '0-Active, 1-Deactive';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-Show, 1-Hide';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_system_requests');
    }
}
