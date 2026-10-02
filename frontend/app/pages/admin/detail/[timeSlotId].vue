<template>
    <p>{{ timeSlotId }}を受け取った予約詳細画面</p>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// 予約日時取得
const timeSlotId = route.params.timeSlotId;

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});
</script>
