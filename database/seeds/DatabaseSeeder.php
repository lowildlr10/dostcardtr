<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agency')->insert([[
            'agency_name' => 'Department of Science and Technology - CAR',
            'abbreviation' => 'DOST-CAR',
            'is_set' => 'y'
        ]]);

        DB::table('agency_profile')->insert([[
            'agency_id' => 1,
            'address' => 'Km.6 BSU Compound La Trinidad, Benguet',
            'zip_code' => '2601',
            'telephone_no' => '(074) 422-2214',
            'email' => 'dost-car@dost.gov.ph',
            'website' => 'car.dost.gov.ph',
            'agency_head' => 20
        ]]);

        DB::table('office')->insert([[
            'office_name' => 'Regional Office'
        ],[
            'office_name' => 'Provincial Science & Technology Center'
        ]]);

        DB::table('division')->insert([[
            'office_id' => 1,
            'division_name' => 'Technical Services Division',
        ],[
            'office_id' => 1,
            'division_name' => 'Finance and Administrative Services',
        ],[
            'office_id' => 1,
            'division_name' => 'Office of the Regional Director',
        ],[
            'office_id' => 2,
            'division_name' => 'PSTC - Abra',
        ],[
            'office_id' => 2,
            'division_name' => 'PSTC - Apayao',
        ],[
            'office_id' => 2,
            'division_name' => 'PSTC - Benguet',
        ],[
            'office_id' => 2,
            'division_name' => 'PSTC - Ifugao',
        ],[
            'office_id' => 2,
            'division_name' => 'PSTC - Kalinga',
        ],[
            'office_id' => 2,
            'division_name' => 'PSTC - Mountain Province',
        ]]);

        DB::table('unit')->insert([[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 35,
            'unit_name' => 'SETUP'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 74,
            'unit_name' => 'LGIA'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 35,
            'unit_name' => 'S&T Promotion'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 35,
            'unit_name' => 'Packaging & Labelling'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 36,
            'unit_name' => 'CEST'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 44,
            'unit_name' => 'DRRM'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 86,
            'unit_name' => 'CIERDeC'
        ],[
            'office_id' => 1,
            'division_id' => 2,
            'unit_head' => 40,
            'unit_name' => 'Property & Supply'
        ],[
            'office_id' => 1,
            'division_id' => 2,
            'unit_head' => 92,
            'unit_name' => 'Budget'
        ],[
            'office_id' => 1,
            'division_id' => 2,
            'unit_head' => 38,
            'unit_name' => 'Accounting'
        ],[
            'office_id' => 1,
            'division_id' => 3,
            'unit_head' => 20,
            'unit_name' => 'Admin'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 86,
            'unit_name' => 'RRDIC'
        ],[
            'office_id' => 1,
            'division_id' => 2,
            'unit_head' => 73,
            'unit_name' => 'CRHRDC'
        ],[
            'office_id' => 1,
            'division_id' => 3,
            'unit_head' => 44,
            'unit_name' => 'MIS'
        ],[
            'office_id' => 1,
            'division_id' => 3,
            'unit_head' => 15,
            'unit_name' => 'Planning'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 86,
            'unit_name' => 'Scholarship'
        ],[
            'office_id' => 1,
            'division_id' => 1,
            'unit_head' => 86,
            'unit_name' => 'RxBox'
        ],[
            'office_id' => 1,
            'division_id' => 2,
            'unit_head' => 73,
            'unit_name' => 'GAD'
        ]]);

        DB::table('user_role')->insert([[
            'role_type' => 'Super User'
        ],[
            'role_type' => 'HR'
        ],[
            'role_type' => 'PSTD'
        ],[
            'role_type' => 'Ordinary User'
        ]]);

        DB::table('paper_size')->insert([[
            'paper_type' => 'A4',
            'width' => 210,
            'height' => 297
        ],[
            'paper_type' => 'Letter',
            'width' => 216,
            'height' => 279
        ],[
            'paper_type' => 'Long',
            'width' => 216,
            'height' => 330
        ],[
            'paper_type' => 'Legal',
            'width' => 216,
            'height' => 356
        ]]);
    }
}
