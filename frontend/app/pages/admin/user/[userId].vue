<template>
    <p>{{ userId }}を受け取った会員詳細画面</p>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// ユーザーid取得
const userId = route.params.userId;

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});
</script>
