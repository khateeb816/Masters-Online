<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;
use App\Models\Message;

class NotificationMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample notifications and messages
        $users = User::all();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                // Create sample notifications
                Notification::create([
                    'title' => 'Welcome to the System',
                    'message' => 'Welcome to our e-commerce management system. We hope you have a great experience!',
                    'type' => 'info',
                    'user_id' => $user->id,
                    'is_read' => false
                ]);

                Notification::create([
                    'title' => 'System Update Available',
                    'message' => 'A new system update is available. Please check the latest features and improvements.',
                    'type' => 'warning',
                    'user_id' => $user->id,
                    'is_read' => false
                ]);

                Notification::create([
                    'title' => 'Order Status Update',
                    'message' => 'Your recent order has been processed successfully.',
                    'type' => 'success',
                    'user_id' => $user->id,
                    'is_read' => true
                ]);

                // Create sample messages between users
                if ($users->count() > 1) {
                    $otherUsers = $users->where('id', '!=', $user->id);
                    foreach ($otherUsers->take(2) as $otherUser) {
                        Message::create([
                            'sender_id' => $user->id,
                            'receiver_id' => $otherUser->id,
                            'subject' => 'Hello from ' . $user->first_name,
                            'message' => 'Hi ' . $otherUser->first_name . ', I hope you are doing well. This is a sample message to test the messaging system.',
                            'is_read' => false
                        ]);

                        Message::create([
                            'sender_id' => $otherUser->id,
                            'receiver_id' => $user->id,
                            'subject' => 'Re: Hello from ' . $user->first_name,
                            'message' => 'Hello ' . $user->first_name . '! Thank you for your message. The messaging system is working perfectly.',
                            'is_read' => true
                        ]);
                    }
                }
            }
        }
    }
}
