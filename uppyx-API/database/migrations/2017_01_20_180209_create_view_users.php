<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW view_users AS (
                SELECT
                    usr.*,
                    rol.name AS role_name,
                    rol.id AS role_id,
                    rent.name as agency_name
                FROM
                    users AS usr
                INNER JOIN role_user AS usrole ON usr.id = usrole.user_id
                INNER JOIN roles AS rol ON usrole.role_id = rol.id
                LEFT JOIN rental_agencies as rent ON usr.rental_agency_id = rent.id);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW view_users');
    }
}
