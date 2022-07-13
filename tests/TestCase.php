<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
    /**
     * Mock the notification dispatcher so all notifications are silenced.
     *
     * @return $this
     */
    protected function withoutNotifications()
    {
        $mock = Mockery::mock(NotificationDispatcher::class);
        $mock->shouldReceive('send')->andReturnUsing(function ($notifiable, $instance, $channels = []) {
            $this->dispatchedNotifications[] = compact(
                'notifiable', 'instance', 'channels'
            );
        });
        $this->app->instance(NotificationDispatcher::class, $mock);
        return $this;
    }

    /**
     * Specify a notification that is expected to be dispatched.
     *
     * @param  mixed $notifiable
     * @param  string $notification
     * @return $this
     */
    protected function expectsNotification($notifiable, $notification)
    {
        $this->withoutNotifications();
        $this->beforeApplicationDestroyed(function () use ($notifiable, $notification) {
            foreach ($this->dispatchedNotifications as $dispatched) {
                $notified = $dispatched['notifiable'];
                if (($notified === $notifiable ||
                        $notified->getKey() == $notifiable->getKey()) &&
                    get_class($dispatched['instance']) === $notification
                ) {
                    return $this;
                }
            }
            throw new Exception(
                'The following expected notification were not dispatched: [' . $notification . ']'
            );
        });
        return $this;
    }

    /**
     * Specify a notification that is not expected to be dispatched.
     *
     * @param  mixed $notifiable
     * @param  string $notification
     * @return $this
     */
    protected function doesntExpectNotification($notifiable, $notification)
    {
        $this->withoutNotifications();
        $this->beforeApplicationDestroyed(function () use ($notifiable, $notification) {
            foreach ($this->dispatchedNotifications as $dispatched) {
                $notified = $dispatched['notifiable'];
                if (($notified === $notifiable ||
                        $notified->getKey() == $notifiable->getKey()) &&
                    get_class($dispatched['instance']) === $notification
                ) {
                    throw new Exception(
                        'These unexpected notifications were fired: [' . $notification . ']'
                    );
                }
            }
        });
        return $this;
    }
}
