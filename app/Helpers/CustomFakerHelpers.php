<?php

use Faker\Factory as Faker;

if(!function_exists('generateCourseName')){
    function generateCourseName(){
        $faker = Faker::create();
        $adjectives = [
            'Advanced',
            'Basics',
            'Intermediate',
            'Comprehensive',
            'Fundamental',
            'Practical',
            'Theoretical'
        ];
        $subjects = [
            'Mathematics', 
            'Physics',
            'Chemistry',
            'Biology',
            'History',
            'Geography',
            'Literature',
            'Philosophy',
            'Economics',
            'Computer Science'
        ];

        $adjective = $faker->randomElement($adjectives);
        $subject = $faker->randomElement($subjects);

        return "$adjective $subject";
    }
}