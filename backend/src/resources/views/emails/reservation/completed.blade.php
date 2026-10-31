<x-mail::message>
    #ご予約が完了しました

    {{ $reservation->user->name }} 様

    いつも▼●▲水泳クラブをご利用いただき、誠にありがとうございます。

    Webサイトより申請いただいたご予約手続きが完了いたしましたので、ご連絡いたします。
    ご予約内容は以下の通りです。当日はお間違いのないようお越しください。

    --------------------------------------------------
    ■ ご予約内容の確認
    --------------------------------------------------
    日時：{{ \Carbon\Carbon::parse($reservation->timeslot->date)->isoFormat('YYYY年M月D日(ddd)') }}
    {{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->format('H:i') }} ～ {{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->addMinutes(30)->format('H:i') }}

    ■ ご予約者様情報
    お名前：{{ $reservation->user->name }} 様
    メールアドレス：{{ $reservation->user->email }}
    --------------------------------------------------

    ※ご予約内容の確認やキャンセルは、予約一覧画面よりお手続きいただけます。

    ▼ 予約一覧はこちら
    http://localhost:3000/list

    ※予約のキャンセルにはログインが必要です。
    ログアウト状態の場合は、ログイン画面よりログインしてください。

    ご不明な点やご質問がございましたら、お気軽にお問い合わせ窓口までご連絡ください。
    当日のご参加を心よりお待ちしております。

    --------------------------------------------------
    ▼●▲水泳クラブ
    URL：
    ログイン画面：http://localhost:3000/login
    予約一覧画面：http://localhost:3000/list

    お問い合わせ：{{ config('mail.from.address') }}
    --------------------------------------------------
</x-mail::message>