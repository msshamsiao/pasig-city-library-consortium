<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public static function create(
        int|User $user,
        string $type,
        string $title,
        string $message,
        ?string $link = null
    ): Notification {
        $userId = $user instanceof User ? $user->id : $user;

        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    /**
     * Notify all super admins
     */
    public static function notifyAdmins(
        string $type,
        string $title,
        string $message,
        ?string $link = null
    ): void {
        $admins = User::where('role', 'super_admin')->get();

        foreach ($admins as $admin) {
            self::create($admin, $type, $title, $message, $link);
        }
    }

    /**
     * Notify all librarians
     */
    public static function notifyLibrarians(
        string $type,
        string $title,
        string $message,
        ?string $link = null
    ): void {
        $librarians = User::where('role', 'member_librarian')->get();

        foreach ($librarians as $librarian) {
            self::create($librarian, $type, $title, $message, $link);
        }
    }

    /**
     * Notify librarian of a specific library
     */
    public static function notifyLibraryLibrarian(
        int $libraryId,
        string $type,
        string $title,
        string $message,
        ?string $link = null
    ): void {
        $librarians = User::where('role', 'member_librarian')
            ->where('library_id', $libraryId)
            ->get();

        foreach ($librarians as $librarian) {
            self::create($librarian, $type, $title, $message, $link);
        }
    }
}
