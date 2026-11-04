<template>
    <p>メール認証完了しました</p>
    <button @click="profile">プロフィール画面へ</button>
</template>

<script setup>
const profile = () => {
    // プロフィール設定画面へ遷移する
    return navigateTo("/profile");
};
</script>
