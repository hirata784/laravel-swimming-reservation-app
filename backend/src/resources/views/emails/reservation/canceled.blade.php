<x-mail::message>
    # ご予約のキャンセルが完了しました

    {{ $reservation->user->name }} 様

    いつも▼●▲水泳クラブをご利用いただき、誠にありがとうございます。

    Webサイトより申請いただいたご予約のキャンセル手続きが完了いたしましたので、
    ご連絡いたします。
    キャンセルされたご予約内容は以下の通りです。

    --------------------------------------------------
    ■ キャンセルされたご予約内容
    --------------------------------------------------
    日時：{{ \Carbon\Carbon::parse($reservation->timeslot->date)->isoFormat('YYYY年M月D日(ddd)') }}
    {{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->format('H:i') }} ～ {{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->addMinutes(30)->format('H:i') }}

    ■ ご予約者様情報
    お名前：{{ $reservation->user->name }} 様
    メールアドレス：{{ $reservation->user->email }}
    --------------------------------------------------

    ※本メールにお心当たりがない場合や、誤ってキャンセル手続きを行ってしまった場合は、
    大変お手数ですが下記のお問い合わせ窓口までご連絡ください。

    またのご利用をスタッフ一同、心よりお待ちしております。

    --------------------------------------------------
    ▼●▲水泳クラブ
    URL：
    ログイン画面：http://localhost:3000/login
    予約一覧画面：http://localhost:3000/list

    お問い合わせ： {{ config('mail.from.address') }}
    --------------------------------------------------
</x-mail::message>