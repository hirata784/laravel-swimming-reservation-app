<template>
    <p>確認画面</p>
    <p>予約者は{{ user.name }}さん</p>
    <p>メールアドレスは{{ user.email }}</p>
    <div>予約日時は{{ date }}の{{ time }}</div>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// 予約日時取得
const date = route.params.date;
const time = route.params.time;
// ユーザー情報取得
const user = ref("");
// トークン取得
const token = useCookie("token");

// 画面構成後に処理
onMounted(async () => {
    const userRes = await $fetch("http://localhost/api/auth/user", {
        headers: {
            Authorization: `Bearer ${token.value}`,
        },
    });
    user.value = userRes;
});
</script>
