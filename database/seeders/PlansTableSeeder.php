<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('plans')->delete();

        \DB::table('plans')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Course Q&A Student Monthly',
                'slug' => 'student_monthly',
                'description' => 'Paying monthly at $5/month is a great option if you only need the service occasionally or if you prefer a flexible payment option that you can cancel at any time. This option is ideal for individuals who are looking for a cost-effective way to get answers to specific questions.',
                'features' => '3-day free trial,Quick responses to complex questions,Fast and accurate results,Makes understanding difficult concepts easy for students',
                'plan_id' => '1',
                'role_id' => 3,
                'default' => 0,
                'price' => '5',
                'trial_days' => 3,
                'created_at' => '2023-02-23 23:00:00',
                'updated_at' => '2023-02-23 23:00:00',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Course Q&A Student Annual',
                'slug' => 'student_annual',
                'description' => 'Paying annually at $50/year is a great option if you need the service on a regular basis. With this option, you\'ll save money compared to paying monthly, and you\'ll have access to the service for an entire year. This option is ideal for students who need assistance with a large amount of coursework throughout the year.',
                'features' => '3-day free trial,All of the same features as the Monthly plan at a discounted rate,12 months for the price of 10',
                'plan_id' => '2',
                'role_id' => 5,
                'default' => 1,
                'price' => '50',
                'trial_days' => 3,
                'created_at' => '2023-02-23 23:00:00',
                'updated_at' => '2023-02-23 23:00:00',
            ),
            // 2 =>
            // array (
            //     'id' => 3,
            //     'name' => 'Pro',
            //     'slug' => 'pro',
            //     'description' => 'Gain access to our pro features with the pro plan.',
            //     'features' => 'Pro Feature Example 1, Pro Feature Example 2, Pro Feature Example 3, Pro Feature Example 4',
            //     'plan_id' => '3',
            //     'role_id' => 4,
            //     'default' => 0,
            //     'price' => '12',
            //     'trial_days' => 14,
            //     'created_at' => '2018-07-03 16:30:43',
            //     'updated_at' => '2018-08-22 22:26:19',
            // ),
        ));


    }
}
