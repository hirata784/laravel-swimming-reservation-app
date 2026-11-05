<template>
    <p>メール認証待ち画面</p>
    <button @click="isResending">再送</button>
</template>

<script setup>
// { resending: 認証メール再送関数 }
const { resending } = useAuth();

// 認証メール再送
const isResending = async () => {
    await resending();
};
</script>
