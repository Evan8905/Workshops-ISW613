<?php

namespace App\Controllers;

use App\Models\Course;
use App\Services\Session;
use App\Services\View;
use PDOException;

final class CourseController
{
    public function index(): void
    {
        Session::requireUser();
        View::render('courses/index', ['courses' => Course::all()]);
    }

    public function create(): void
    {
        Session::requireUser();
        View::render('courses/form', ['course' => $this->emptyCourse(), 'isEditing' => false]);
    }

    public function edit(): void
    {
        Session::requireUser();
        $id = $_GET['id'] ?? null;
        if (!is_string($id) || !ctype_digit($id) || (int) $id < 1 || ($course = Course::find((int) $id)) === false) {
            Session::redirect('courses', 'error', 'course_not_found');
        }
        View::render('courses/form', ['course' => $course, 'isEditing' => true]);
    }

    public function save(): void
    {
        Session::requireUser();
        $id = $_POST['id'] ?? null;
        $course = $this->validatedCourse();
        if ($course === null || ($id !== null && (!is_string($id) || !ctype_digit($id) || (int) $id < 1))) {
            Session::redirect('courses', 'error', 'invalid_input');
        }
        try {
            if ($id !== null && Course::find((int) $id) === false) {
                Session::redirect('courses', 'error', 'course_not_found');
            }
            Course::save($course, $id === null ? null : (int) $id);
        } catch (PDOException $exception) {
            Session::redirect('courses', 'error', $exception->getCode() === '23000' ? 'course_code_taken' : 'server_error');
        }
        Session::redirect('courses', 'success', 'course_saved');
    }

    public function delete(): void
    {
        Session::requireUser();
        $id = $_POST['id'] ?? null;
        if (!is_string($id) || !ctype_digit($id) || (int) $id < 1) Session::redirect('courses', 'error', 'invalid_input');
        try {
            if (!Course::delete((int) $id)) Session::redirect('courses', 'error', 'course_not_found');
        } catch (PDOException $exception) {
            Session::redirect('courses', 'error', 'server_error');
        }
        Session::redirect('courses', 'success', 'course_deleted');
    }

    private function emptyCourse(): array
    {
        return ['name' => '', 'course_code' => '', 'career_id' => '', 'credits' => '', 'description' => ''];
    }

    private function validatedCourse(): ?array
    {
        $name = $_POST['name'] ?? null;
        $code = $_POST['course_code'] ?? null;
        $careerId = $_POST['career_id'] ?? null;
        $credits = $_POST['credits'] ?? null;
        $description = $_POST['description'] ?? null;
        if (!is_string($name) || !is_string($code) || !is_string($careerId) || !is_string($credits) || !is_string($description) || trim($name) === '' || strlen(trim($name)) > 100 || trim($code) === '' || strlen(trim($code)) > 20 || !ctype_digit($careerId) || (int) $careerId < 1 || !ctype_digit($credits) || (int) $credits < 1) {
            return null;
        }
        return ['name' => trim($name), 'course_code' => trim($code), 'career_id' => (int) $careerId, 'credits' => (int) $credits, 'description' => trim($description)];
    }
}
