<template>
    <p>予約管理画面</p>
</template>

<script setup>
definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});
</script>
