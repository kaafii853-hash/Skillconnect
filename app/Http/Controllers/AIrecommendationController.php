<!-- halo wok -->

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AIRecommendationController extends Controller
{
    /**
     * Recommend Skills
     */
    public function recommendSkills(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'level' => 'required|in:beginner,intermediate,advanced',
            'goal' => 'required|string',
            'current_skills' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // TODO: Integrate dengan AI API (Claude/OpenAI)
        // Untuk sekarang return dummy data
        
        $skills = ['React.js', 'TypeScript', 'Node.js', 'Docker', 'AWS'];
        $learningPath = [
            'Kuasai JavaScript ES6+ fundamental',
            'Pelajari React.js dan component lifecycle',
            'Dalami TypeScript untuk type safety',
            'Backend development dengan Node.js & Express',
            'DevOps basics dengan Docker dan deployment'
        ];

        return response()->json([
            'success' => true,
            'skills' => $skills,
            'learning_path' => $learningPath,
            'user_input' => [
                'position' => $request->position,
                'level' => $request->level,
                'goal' => $request->goal,
            ]
        ]);
    }

    /**
     * Recommend Jobs
     */
    public function recommendJobs(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'skills' => 'required|string',
            'job_type' => 'required|in:onsite,remote,hybrid',
            'salary_expectation' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // TODO: Integrate dengan AI API dan Job Database
        // Untuk sekarang return dummy data
        
        $jobs = [
            [
                'id' => 1,
                'title' => 'Frontend Developer',
                'company' => 'Tokopedia',
                'match_score' => 95,
                'salary_min' => 12000000,
                'salary_max' => 18000000,
                'type' => 'Full-time',
                'work_arrangement' => 'Remote',
                'location' => 'Jakarta',
            ],
            [
                'id' => 2,
                'title' => 'React Developer',
                'company' => 'Gojek',
                'match_score' => 92,
                'salary_min' => 15000000,
                'salary_max' => 22000000,
                'type' => 'Full-time',
                'work_arrangement' => 'Hybrid',
                'location' => 'Jakarta',
            ],
            [
                'id' => 3,
                'title' => 'Full Stack Developer',
                'company' => 'Bukalapak',
                'match_score' => 88,
                'salary_min' => 13000000,
                'salary_max' => 20000000,
                'type' => 'Full-time',
                'work_arrangement' => 'On-site',
                'location' => 'Jakarta',
            ]
        ];

        return response()->json([
            'success' => true,
            'jobs' => $jobs,
            'total' => count($jobs)
        ]);
    }

    /**
     * Recommend Courses
     */
    public function recommendCourses(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'interest' => 'required|string|max:255',
            'level' => 'required|in:beginner,intermediate,advanced',
            'goal' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // TODO: Integrate dengan AI API dan Course Database
        // Untuk sekarang return dummy data
        
        $courses = [
            [
                'id' => 1,
                'title' => 'The Complete Web Developer Bootcamp',
                'platform' => 'Udemy',
                'duration_weeks' => 12,
                'price' => 299000,
                'match_score' => 96,
                'skills' => ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js'],
                'instructor' => 'Angela Yu',
                'rating' => 4.7,
                'students' => 125000
            ],
            [
                'id' => 2,
                'title' => 'Modern React with Redux',
                'platform' => 'Udemy',
                'duration_weeks' => 8,
                'price' => 349000,
                'match_score' => 94,
                'skills' => ['React', 'Redux', 'Hooks', 'Context API'],
                'instructor' => 'Stephen Grider',
                'rating' => 4.6,
                'students' => 89000
            ],
            [
                'id' => 3,
                'title' => 'Advanced JavaScript Concepts',
                'platform' => 'Udemy',
                'duration_weeks' => 6,
                'price' => 279000,
                'match_score' => 91,
                'skills' => ['ES6+', 'Async/Await', 'OOP', 'Functional Programming'],
                'instructor' => 'Andrei Neagoie',
                'rating' => 4.8,
                'students' => 67000
            ]
        ];

        return response()->json([
            'success' => true,
            'courses' => $courses,
            'total' => count($courses)
        ]);
    }
}