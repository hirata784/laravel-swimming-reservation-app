<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 認証メールの文章を直接日本語で上書きする
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('メールアドレスの確認') // 件名
                ->greeting('こんにちは！') // 挨拶
                ->line('以下のボタンをクリックして、メールアドレスの確認を完了してください。')
                ->action('メールアドレスの確認', $url) // ボタンの文字とURL
                ->line('もしアカウントを作成した覚えがない場合は、これ以上の操作は必要ありません。')
                ->salutation('よろしくお願いいたします。'); // 結びの言葉
        });
    }
}
