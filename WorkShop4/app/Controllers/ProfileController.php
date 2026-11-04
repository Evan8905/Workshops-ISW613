<?php

namespace App\Controllers;

use App\Models\Province;
use App\Models\User;
use App\Services\Session;
use App\Services\UploadService;
use App\Services\View;
use PDOException;

final class ProfileController
{
    public function show(): void
    {
        View::render('profile/show', ['user' => Session::requireUser(), 'provinces' => Province::all()]);
    }

    public function update(): void
    {
        $user = Session::requireUser();
        $username = $_POST['username'] ?? null;
        $provinceId = $_POST['province_id'] ?? null;
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmation = $_POST['confirm_password'] ?? '';
        if (!is_string($username) || !is_string($currentPassword) || !is_string($newPassword) || !is_string($confirmation) || trim($username) === '' || strlen(trim($username)) > 50 || !ctype_digit((string) $provinceId)) {
            Session::redirect('profile', 'error', 'invalid_input');
        }
        $province = Province::find((int) $provinceId);
        if ($province === false) Session::redirect('profile', 'error', 'invalid_province');
        $passwordHash = null;
        if ($newPassword !== '') {
            if (strlen($newPassword) < 8) Session::redirect('profile', 'error', 'password_too_short');
            if ($newPassword !== $confirmation) Session::redirect('profile', 'error', 'password_mismatch');
            $existingHash = User::passwordHash((int) $user['id']);
            if ($existingHash === false || !password_verify($currentPassword, $existingHash)) Session::redirect('profile', 'error', 'wrong_password');
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        $upload = UploadService::store($_FILES['profile_picture'] ?? null);
        if (isset($upload['error'])) Session::redirect('profile', 'error', $upload['error']);
        $newPicture = $upload['filename'];
        $oldPicture = $newPicture === null ? null : User::profilePicture((int) $user['id']);
        try {
            User::update((int) $user['id'], trim($username), (int) $province['id'], $passwordHash, $newPicture);
        } catch (PDOException $exception) {
            if ($newPicture !== null) UploadService::delete($newPicture);
            Session::redirect('profile', 'error', $exception->getCode() === '23000' ? 'username_taken' : 'server_error');
        }
        if ($newPicture !== null) UploadService::delete($oldPicture ?: null);
        $user['username'] = trim($username);
        $user['province_id'] = (int) $province['id'];
        $user['province_name'] = $province['name'];
        if ($newPicture !== null) $user['profile_picture'] = $newPicture;
        Session::updateUser($user);
        if (isset($_COOKIE[Session::REMEMBER_COOKIE])) Session::remember($user['username']);
        Session::redirect('profile', 'success', 'updated');
    }
}
